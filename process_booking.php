<?php

/*
|--------------------------------------------------------------------------
| Process Equipment Booking
|--------------------------------------------------------------------------
|
| This file:
|
| 1. Accepts booking form data
| 2. Validates customer information
| 3. Verifies equipment exists and is active
| 4. Gets rental/purchase price from DB
| 5. Finds or creates the customer
| 6. Reuses an existing pending booking/order when possible
| 7. Creates a new booking when required
| 8. Generates a unique booking number
| 9. Creates a Razorpay Order when required
| 10. Saves the Razorpay Order ID
| 11. Returns JSON response
|
|--------------------------------------------------------------------------
*/

header('Content-Type: application/json');

require_once 'conn.php';
require_once __DIR__ . '/config/razorpay_helper.php';

$razorpayConfig = require __DIR__ . '/config/razorpay.php';


/*
|--------------------------------------------------------------------------
| Only POST Requests
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get Form Data
|--------------------------------------------------------------------------
*/

$equipmentId = isset($_POST['equipment_id'])
    ? (int) $_POST['equipment_id']
    : 0;

$customerName = trim($_POST['name'] ?? '');

$mobile = trim($_POST['mobile'] ?? '');

$email = trim($_POST['email'] ?? '');

$city = trim($_POST['city'] ?? '');

$bookingType = trim($_POST['booking_type'] ?? '');


/*
|--------------------------------------------------------------------------
| Basic Validation
|--------------------------------------------------------------------------
*/

if ($equipmentId <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid equipment selected.'
    ]);

    exit;
}


if ($customerName === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter your name.'
    ]);

    exit;
}


if (!preg_match('/^[0-9]{10}$/', $mobile)) {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid 10-digit mobile number.'
    ]);

    exit;
}


if ($city === '') {

    echo json_encode([
        'success' => false,
        'message' => 'Please select your city.'
    ]);

    exit;
}


if (!in_array($bookingType, ['rental', 'purchase'], true)) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid booking type.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Email Validation
|--------------------------------------------------------------------------
*/

if (
    $email !== '' &&
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Validate City
|--------------------------------------------------------------------------
*/

$allowedCities = [
    'Pune',
    'Chandrapur'
];

if (!in_array($city, $allowedCities, true)) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid city selected.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Equipment
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| We do NOT trust the amount sent by JavaScript.
| The price is always fetched from the database.
|
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        e.id,
        e.name,
        e.rental_price,
        e.purchase_price,
        e.status,
        c.status AS category_status

    FROM equipment e

    INNER JOIN equipment_categories c
        ON c.id = e.category_id

    WHERE e.id = ?
      AND e.status = 1
      AND c.status = 1

    LIMIT 1
");

$stmt->execute([$equipmentId]);

$equipment = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Equipment Not Found
|--------------------------------------------------------------------------
*/

if (!$equipment) {

    echo json_encode([
        'success' => false,
        'message' => 'Selected equipment is not available.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Determine Amount
|--------------------------------------------------------------------------
*/

if ($bookingType === 'rental') {

    $amount = $equipment['rental_price'];

} else {

    $amount = $equipment['purchase_price'];
}


/*
|--------------------------------------------------------------------------
| Check Price Availability
|--------------------------------------------------------------------------
*/

if ($amount === null || $amount === '') {

    $amount = null;
}


/*
|--------------------------------------------------------------------------
| Payment Amount Validation
|--------------------------------------------------------------------------
*/

if ($amount === null || (float) $amount <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Payment amount is not available for this equipment.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Convert Amount To Paise
|--------------------------------------------------------------------------
|
| Razorpay expects INR amounts in paise.
|
| Example:
|
| ₹25,000 = 2500000 paise
|
|--------------------------------------------------------------------------
*/

$razorpayAmount = (int) round((float) $amount * 100);


/*
|--------------------------------------------------------------------------
| Create / Find Customer + Booking + Razorpay Order
|--------------------------------------------------------------------------
*/

try {

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | Find Existing Customer
    |--------------------------------------------------------------------------
    |
    | Mobile number is currently our unique customer identifier.
    |
    | FOR UPDATE prevents two simultaneous booking requests from
    | creating duplicate pending bookings for the same customer.
    |
    */

    $stmt = $pdo->prepare("
        SELECT
            id,
            customer_number,
            name,
            mobile,
            email,
            city,
            status
        FROM customers
        WHERE mobile = ?
        LIMIT 1
        FOR UPDATE
    ");

    $stmt->execute([
        $mobile
    ]);

    $customer = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Existing Customer
    |--------------------------------------------------------------------------
    */

    if ($customer) {

        $customerId = (int) $customer['id'];


        /*
        |--------------------------------------------------------------
        | Update Current Customer Information
        |--------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            UPDATE customers
            SET
                name = ?,
                email = ?,
                city = ?,
                status = 'active'
            WHERE id = ?
        ");

        $stmt->execute([
            $customerName,
            $email !== '' ? $email : null,
            $city,
            $customerId
        ]);


        $customerNumber = $customer['customer_number'];

    }


    /*
    |--------------------------------------------------------------------------
    | New Customer
    |--------------------------------------------------------------------------
    */

    else {

        /*
        |--------------------------------------------------------------
        | Temporary Customer Number
        |--------------------------------------------------------------
        */

        $temporaryCustomerNumber =
            'JIV-CUST-TEMP-' .
            strtoupper(bin2hex(random_bytes(6)));


        $stmt = $pdo->prepare("
            INSERT INTO customers (
                customer_number,
                name,
                mobile,
                email,
                city,
                status
            )
            VALUES (
                ?,
                ?,
                ?,
                ?,
                ?,
                'active'
            )
        ");

        $stmt->execute([
            $temporaryCustomerNumber,
            $customerName,
            $mobile,
            $email !== '' ? $email : null,
            $city
        ]);


        /*
        |--------------------------------------------------------------
        | Get Customer ID
        |--------------------------------------------------------------
        */

        $customerId = (int) $pdo->lastInsertId();


        /*
        |--------------------------------------------------------------
        | Generate Permanent Customer Number
        |--------------------------------------------------------------
        */

        $customerNumber =
            'JIV-CUST-' .
            str_pad(
                $customerId,
                5,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------
        | Save Customer Number
        |--------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            UPDATE customers
            SET customer_number = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $customerNumber,
            $customerId
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Check For Existing Pending Booking
    |--------------------------------------------------------------------------
    |
    | If this customer already has a pending + unpaid booking for
    | the same equipment and booking type, reuse it.
    |
    | This prevents:
    |
    | Booking A -> Payment cancelled
    | Booking B -> New Razorpay order
    |
    | Instead:
    |
    | Booking A -> Payment cancelled
    | Booking A -> Retry same Razorpay order
    |
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT
            id,
            booking_number,
            amount,
            razorpay_order_id
        FROM equipment_bookings
        WHERE customer_id = ?
          AND equipment_id = ?
          AND booking_type = ?
          AND booking_status = 'pending'
          AND payment_status = 'pending'
          AND razorpay_order_id IS NOT NULL
          AND razorpay_order_id != ''
        ORDER BY id DESC
        LIMIT 1
        FOR UPDATE
    ");

    $stmt->execute([
        $customerId,
        $equipmentId,
        $bookingType
    ]);

    $pendingBooking = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Reuse Existing Pending Booking
    |--------------------------------------------------------------------------
    */

    if ($pendingBooking) {

        /*
        |--------------------------------------------------------------
        | Check That The Current Price Matches The Existing Booking
        |--------------------------------------------------------------
        |
        | Razorpay orders cannot simply have their amount changed.
        |
        | If the equipment price changed since the pending booking
        | was created, we create a new booking instead.
        |
        */

        if ((float) $pendingBooking['amount'] === (float) $amount) {

            $bookingId = (int) $pendingBooking['id'];

            $bookingNumber = $pendingBooking['booking_number'];

            $razorpayOrderId = $pendingBooking['razorpay_order_id'];


            /*
            |----------------------------------------------------------
            | Commit Existing Booking Reuse
            |----------------------------------------------------------
            */

            $pdo->commit();


            /*
            |----------------------------------------------------------
            | Return Existing Booking
            |----------------------------------------------------------
            */

            echo json_encode([
                'success' => true,
                'message' => 'Existing pending booking found. Payment can be retried.',

                'booking_id' => $bookingId,

                'booking_number' => $bookingNumber,

                'customer_id' => $customerId,

                'customer_number' => $customerNumber,

                'customer_name' => $customerName,

                'mobile' => $mobile,

                'email' => $email,

                'equipment_name' => $equipment['name'],

                'booking_type' => $bookingType,

                'amount' => (float) $amount,

                'razorpay_order_id' => $razorpayOrderId,

                'razorpay_key_id' => $razorpayConfig['key_id'],

                'razorpay_amount' => $razorpayAmount,

                'payment_required' => true,

                'existing_booking' => true
            ]);

            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Create New Booking
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO equipment_bookings (
            customer_id,
            equipment_id,
            customer_name,
            mobile,
            email,
            city,
            booking_type,
            amount,
            booking_status,
            payment_status
        )
        VALUES (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            'pending',
            'pending'
        )
    ");

    $stmt->execute([
        $customerId,
        $equipmentId,
        $customerName,
        $mobile,
        $email !== '' ? $email : null,
        $city,
        $bookingType,
        $amount
    ]);


    /*
    |--------------------------------------------------------------------------
    | Get Booking ID
    |--------------------------------------------------------------------------
    */

    $bookingId = (int) $pdo->lastInsertId();


    /*
    |--------------------------------------------------------------------------
    | Generate Booking Number
    |--------------------------------------------------------------------------
    */

    $bookingNumber =
        'JIV-' .
        date('Ymd') .
        '-' .
        str_pad(
            $bookingId,
            5,
            '0',
            STR_PAD_LEFT
        );


    /*
    |--------------------------------------------------------------------------
    | Save Booking Number
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE equipment_bookings
        SET booking_number = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $bookingNumber,
        $bookingId
    ]);


    /*
    |--------------------------------------------------------------------------
    | Create Razorpay Order
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | The amount comes from the database.
    | We do NOT trust any amount sent by JavaScript.
    |
    |--------------------------------------------------------------------------
    */

    $razorpayOrder = createRazorpayOrder(
        $razorpayConfig['key_id'],
        $razorpayConfig['key_secret'],
        $razorpayAmount,
        $bookingNumber,
        [
            'booking_id' => (string) $bookingId,
            'booking_number' => $bookingNumber,
            'customer_id' => (string) $customerId,
            'equipment_id' => (string) $equipmentId,
            'booking_type' => $bookingType
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Save Razorpay Order ID
    |--------------------------------------------------------------------------
    */

    $razorpayOrderId = $razorpayOrder['id'];

    $stmt = $pdo->prepare("
        UPDATE equipment_bookings
        SET razorpay_order_id = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $razorpayOrderId,
        $bookingId
    ]);


    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $pdo->commit();


    /*
    |--------------------------------------------------------------------------
    | Success Response
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'message' => 'Booking created and payment order generated.',

        'booking_id' => $bookingId,

        'booking_number' => $bookingNumber,

        'customer_id' => $customerId,

        'customer_number' => $customerNumber,

        'customer_name' => $customerName,

        'mobile' => $mobile,

        'email' => $email,

        'equipment_name' => $equipment['name'],

        'booking_type' => $bookingType,

        'amount' => (float) $amount,

        'razorpay_order_id' => $razorpayOrderId,

        'razorpay_key_id' => $razorpayConfig['key_id'],

        'razorpay_amount' => $razorpayAmount,

        'payment_required' => true,

        'existing_booking' => false
    ]);

    exit;


} catch (Throwable $e) {

    if ($pdo->inTransaction()) {

        $pdo->rollBack();
    }

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Booking/payment order error: ' . $e->getMessage()
    ]);

    exit;
}