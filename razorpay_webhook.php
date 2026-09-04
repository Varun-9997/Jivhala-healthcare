<?php

/*
|--------------------------------------------------------------------------
| Razorpay Webhook
|--------------------------------------------------------------------------
|
| This endpoint receives server-to-server payment notifications
| from Razorpay.
|
| We currently handle:
|
| - payment.captured
| - order.paid
|
|--------------------------------------------------------------------------
*/

header('Content-Type: application/json');

require_once 'conn.php';


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
| Load Webhook Secret
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| This is NOT the Razorpay API key secret.
| It is a separate secret that we will create in the
| Razorpay Dashboard while configuring the webhook.
|
|--------------------------------------------------------------------------
*/

$razorpayConfig = require __DIR__ . '/config/razorpay.php';

$webhookSecret = $razorpayConfig['webhook_secret'] ?? '';

if ($webhookSecret === '') {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Webhook secret is not configured.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get Raw Request Body
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| Razorpay webhook signature MUST be calculated using
| the raw request body.
|
|--------------------------------------------------------------------------
*/

$rawBody = file_get_contents('php://input');

if ($rawBody === false || $rawBody === '') {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Empty webhook request.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get Razorpay Signature
|--------------------------------------------------------------------------
*/

$receivedSignature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

if ($receivedSignature === '') {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Webhook signature missing.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Verify Webhook Signature
|--------------------------------------------------------------------------
*/

$expectedSignature = hash_hmac(
    'sha256',
    $rawBody,
    $webhookSecret
);

if (!hash_equals($expectedSignature, $receivedSignature)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid webhook signature.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Decode Webhook Payload
|--------------------------------------------------------------------------
*/

$payload = json_decode($rawBody, true);

if (!is_array($payload)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid webhook payload.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get Event Name
|--------------------------------------------------------------------------
*/

$event = $payload['event'] ?? '';


/*
|--------------------------------------------------------------------------
| Only Process Successful Payment Events
|--------------------------------------------------------------------------
|
| payment.captured and order.paid are both sent when an order
| has been successfully paid/captured.
|
|--------------------------------------------------------------------------
*/

if (!in_array($event, ['payment.captured', 'order.paid'], true)) {

    /*
    |--------------------------------------------------------------
    | Return 200 for events we don't currently handle.
    |--------------------------------------------------------------
    */

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'Event received but not processed.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Extract Payment / Order Information
|--------------------------------------------------------------------------
*/

$paymentEntity =
    $payload['payload']['payment']['entity']
    ?? null;

$orderEntity =
    $payload['payload']['order']['entity']
    ?? null;


/*
|--------------------------------------------------------------------------
| Determine Razorpay Order ID
|--------------------------------------------------------------------------
*/

$razorpayOrderId = '';

if ($paymentEntity && !empty($paymentEntity['order_id'])) {

    $razorpayOrderId = trim(
        $paymentEntity['order_id']
    );

}

elseif ($orderEntity && !empty($orderEntity['id'])) {

    $razorpayOrderId = trim(
        $orderEntity['id']
    );
}


/*
|--------------------------------------------------------------------------
| Determine Razorpay Payment ID
|--------------------------------------------------------------------------
*/

$razorpayPaymentId = '';

if ($paymentEntity && !empty($paymentEntity['id'])) {

    $razorpayPaymentId = trim(
        $paymentEntity['id']
    );
}


/*
|--------------------------------------------------------------------------
| Validate Order ID
|--------------------------------------------------------------------------
*/

if ($razorpayOrderId === '') {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Razorpay order ID not found.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Payment Must Be Captured
|--------------------------------------------------------------------------
*/

if ($event === 'payment.captured') {

    $paymentStatus =
        $paymentEntity['status']
        ?? '';

    $captured =
        $paymentEntity['captured']
        ?? false;

    if (
        $paymentStatus !== 'captured' ||
        $captured !== true
    ) {

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'message' => 'Payment event received but payment is not captured.'
        ]);

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Find Booking
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare("
        SELECT
            id,
            booking_number,
            amount,
            payment_status,
            booking_status,
            razorpay_order_id,
            razorpay_payment_id
        FROM equipment_bookings
        WHERE razorpay_order_id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $razorpayOrderId
    ]);

    $booking = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Booking Not Found
    |--------------------------------------------------------------------------
    */

    if (!$booking) {

        /*
        |--------------------------------------------------------------
        | Return 200 so Razorpay doesn't repeatedly retry an event
        | that belongs to an unknown order.
        |--------------------------------------------------------------
        */

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'message' => 'Webhook received. Booking not found.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Already Paid
    |--------------------------------------------------------------------------
    */

    if ($booking['payment_status'] === 'paid') {

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'message' => 'Payment already processed.',
            'booking_number' => $booking['booking_number']
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Update Booking
    |--------------------------------------------------------------------------
    */

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | Update Only Pending Payments
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE equipment_bookings
        SET
            payment_status = 'paid',
            razorpay_payment_id = ?,
            paid_at = NOW(),
            booking_status = 'confirmed'
        WHERE id = ?
          AND payment_status = 'pending'
    ");

    $stmt->execute([
        $razorpayPaymentId !== ''
            ? $razorpayPaymentId
            : $booking['razorpay_payment_id'],

        $booking['id']
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

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'Webhook processed successfully.',
        'booking_number' => $booking['booking_number']
    ]);

    exit;


} catch (Throwable $e) {

    if ($pdo->inTransaction()) {

        $pdo->rollBack();
    }


    /*
    |--------------------------------------------------------------------------
    | Return 500
    |--------------------------------------------------------------------------
    |
    | Returning 500 tells Razorpay that processing failed.
    | Razorpay can retry the webhook.
    |
    |--------------------------------------------------------------------------
    */

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Webhook processing failed.'
    ]);

    exit;
}