<?php

session_name('JIVHALA_ADMIN_SESSION');
session_start();


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Session Timeout - 30 Minutes
|--------------------------------------------------------------------------
*/

$timeout = 30 * 60;

if (
    isset($_SESSION['last_activity']) &&
    (time() - $_SESSION['last_activity']) > $timeout
) {
    session_unset();
    session_destroy();

    header("Location: login.php?timeout=1");
    exit;
}

$_SESSION['last_activity'] = time();

$adminName = $_SESSION['admin_name'] ?? 'Administrator';


/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

require_once '../conn.php';


/*
|--------------------------------------------------------------------------
| Booking ID
|--------------------------------------------------------------------------
*/

$bookingId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($bookingId <= 0) {
    header("Location: bookings.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
*/

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}


function formatDateTime($date)
{
    if (empty($date)) {
        return '-';
    }

    return date('d M Y, h:i A', strtotime($date));
}


function formatAmount($amount)
{
    if ($amount === null || $amount === '') {
        return 'Not set';
    }

    return '₹' . number_format((float) $amount, 2);
}


/*
|--------------------------------------------------------------------------
| Update Booking Status
|--------------------------------------------------------------------------
*/

$statusMessage = '';
$statusError = '';

$allowedStatuses = [
    'pending',
    'confirmed',
    'completed',
    'cancelled'
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newStatus = trim($_POST['booking_status'] ?? '');

    if (!in_array($newStatus, $allowedStatuses, true)) {

        $statusError = 'Invalid booking status selected.';

    } else {

        try {

            $stmt = $pdo->prepare("
                UPDATE equipment_bookings
                SET booking_status = ?
                WHERE id = ?
                LIMIT 1
            ");

            $stmt->execute([
                $newStatus,
                $bookingId
            ]);

            $statusMessage = 'Booking status updated successfully.';

        } catch (Throwable $e) {

            $statusError = 'Unable to update booking status.';
        }
    }
}


/*
|--------------------------------------------------------------------------
| Fetch Booking
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        b.id,
        b.booking_number,

        b.customer_id,
        b.customer_name,
        b.mobile,
        b.email,
        b.city,

        b.equipment_id,
        e.name AS equipment_name,
        e.description AS equipment_description,
        e.rental_price,
        e.purchase_price,

        b.booking_type,
        b.amount,

        b.booking_status,
        b.payment_status,

        b.razorpay_order_id,
        b.razorpay_payment_id,
        b.paid_at,

        b.created_at,
        b.updated_at

    FROM equipment_bookings b

    LEFT JOIN equipment e
        ON e.id = b.equipment_id

    WHERE b.id = ?

    LIMIT 1
");

$stmt->execute([$bookingId]);

$booking = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$booking) {
    header("Location: bookings.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Customer Number
|--------------------------------------------------------------------------
*/

$customerNumber = null;

if (!empty($booking['customer_id'])) {

    $stmt = $pdo->prepare("
        SELECT customer_number
        FROM customers
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $booking['customer_id']
    ]);

    $customerNumber = $stmt->fetchColumn();
}


/*
|--------------------------------------------------------------------------
| Status Styling
|--------------------------------------------------------------------------
*/

$statusClass = match ($booking['booking_status']) {

    'confirmed' =>
        'bg-blue-50 text-blue-700',

    'completed' =>
        'bg-slate-100 text-slate-700',

    'cancelled' =>
        'bg-slate-100 text-slate-500',

    default =>
        'bg-slate-100 text-slate-600'
};


$paymentClass = match ($booking['payment_status']) {

    'paid' =>
        'bg-blue-50 text-blue-700',

    'failed' =>
        'bg-slate-100 text-slate-500',

    default =>
        'bg-slate-100 text-slate-600'
};

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= e($booking['booking_number'] ?: 'Booking Details') ?>
        | Jivhala Healthcare
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        .page-bg {
            background:
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f4f7fb 50%,
                    #f8fafc 100%
                );
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5eaf2;
            box-shadow:
                0 2px 8px rgba(15, 23, 42, 0.035);
        }

        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

    </style>

</head>


<body class="page-bg text-slate-800 antialiased">


<?php include 'header.php'; ?>


<div class="flex min-h-[calc(100vh-5rem)]">


    <?php include 'sidebar.php'; ?>


    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <main class="flex-1 overflow-x-hidden">


        <div
            class="max-w-[1450px] mx-auto px-4 sm:px-6 lg:px-8 py-4"
        >


            <!-- ===================================================== -->
            <!-- TOP BAR -->
            <!-- ===================================================== -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4"
            >

                <!-- Back + Booking Number -->

                <div>

                    <a
                        href="bookings.php"
                        class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#17233C] transition-colors mb-2"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7"
                            />

                        </svg>

                        Back to Bookings

                    </a>


                    <div class="flex items-center gap-3">

                        <div
                            class="w-1 h-9 rounded-full bg-teal-500"
                        ></div>

                        <div>

                            <p
                                class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                            >
                                Booking Details
                            </p>

                            <h1
                                class="text-xl sm:text-2xl font-black tracking-tight text-[#17233C]"
                            >

                                <?= e(
                                    $booking['booking_number']
                                    ?: 'JIV-' . str_pad(
                                        $booking['id'],
                                        5,
                                        '0',
                                        STR_PAD_LEFT
                                    )
                                ) ?>

                            </h1>

                            <p class="text-xs text-slate-500 mt-0.5">

                                Created
                                <?= formatDateTime(
                                    $booking['created_at']
                                ) ?>

                            </p>

                        </div>

                    </div>

                </div>


                <!-- Current Status -->

                <div class="flex items-center gap-2 sm:pr-1">

                    <span
                        class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                    >
                        Booking Status
                    </span>

                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase <?= $statusClass ?>"
                    >

                        <span
                            class="w-1.5 h-1.5 rounded-full bg-current"
                        ></span>

                        <?= ucfirst(
                            e($booking['booking_status'])
                        ) ?>

                    </span>

                </div>

            </div>


            <!-- ===================================================== -->
            <!-- SUCCESS / ERROR -->
            <!-- ===================================================== -->

            <?php if ($statusMessage !== ''): ?>

                <div
                    class="mb-3 rounded-lg border border-blue-100 bg-blue-50 px-4 py-2.5 flex items-center gap-3"
                >

                    <div
                        class="w-7 h-7 rounded-lg bg-white text-blue-600 flex items-center justify-center shrink-0"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />

                        </svg>

                    </div>

                    <p class="text-xs font-semibold text-blue-800">

                        <?= e($statusMessage) ?>

                    </p>

                </div>

            <?php endif; ?>


            <?php if ($statusError !== ''): ?>

                <div
                    class="mb-3 rounded-lg border border-slate-200 bg-slate-100 px-4 py-2.5"
                >

                    <p
                        class="text-xs font-semibold text-slate-700"
                    >

                        <?= e($statusError) ?>

                    </p>

                </div>

            <?php endif; ?>


            <!-- ===================================================== -->
            <!-- TOP INFORMATION -->
            <!-- ===================================================== -->

            <div
                class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-3"
            >


                <!-- ================================================= -->
                <!-- CUSTOMER -->
                <!-- ================================================= -->

                <div class="card rounded-xl overflow-hidden">

                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center"
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >

                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="4"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 21a8 8 0 0116 0"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h2
                                    class="text-sm font-extrabold text-[#17233C]"
                                >
                                    Customer
                                </h2>

                                <p class="text-[10px] text-slate-400">
                                    Customer information
                                </p>

                            </div>

                        </div>

                    </div>


                    <div
                        class="p-4 grid grid-cols-2 gap-x-5 gap-y-3"
                    >

                        <div>

                            <p class="info-label">
                                Name
                            </p>

                            <p class="info-value">

                                <?= e(
                                    $booking['customer_name']
                                ) ?>

                            </p>

                        </div>


                        <div>

                            <p class="info-label">
                                Customer Number
                            </p>

                            <p class="info-value">

                                <?php if ($customerNumber): ?>

                                    <?= e($customerNumber) ?>

                                <?php else: ?>

                                    <span class="text-slate-400">
                                        Not available
                                    </span>

                                <?php endif; ?>

                            </p>

                        </div>


                        <div>

                            <p class="info-label">
                                Mobile
                            </p>

                            <p class="info-value">

                                <?= e(
                                    $booking['mobile']
                                ) ?>

                            </p>

                        </div>


                        <div>

                            <p class="info-label">
                                City
                            </p>

                            <p class="info-value">

                                <?= e(
                                    $booking['city']
                                ) ?>

                            </p>

                        </div>


                        <div class="col-span-2">

                            <p class="info-label">
                                Email
                            </p>

                            <p class="info-value break-all">

                                <?php if (
                                    !empty($booking['email'])
                                ): ?>

                                    <?= e(
                                        $booking['email']
                                    ) ?>

                                <?php else: ?>

                                    <span class="text-slate-400">
                                        Not provided
                                    </span>

                                <?php endif; ?>

                            </p>

                        </div>

                    </div>

                </div>



                <!-- ================================================= -->
                <!-- EQUIPMENT -->
                <!-- ================================================= -->

                <div class="card rounded-xl overflow-hidden">

                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >

                                    <rect
                                        x="3"
                                        y="4"
                                        width="18"
                                        height="16"
                                        rx="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 9h12M6 13h12M6 17h6"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h2
                                    class="text-sm font-extrabold text-[#17233C]"
                                >
                                    Equipment
                                </h2>

                                <p class="text-[10px] text-slate-400">
                                    Booked equipment
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-4">

                        <p
                            class="text-base font-black text-[#17233C] leading-snug"
                        >

                            <?= e(
                                $booking['equipment_name']
                                ?: 'Equipment unavailable'
                            ) ?>

                        </p>


                        <div
                            class="grid grid-cols-2 gap-4 mt-5 pt-4 border-t border-slate-100"
                        >

                            <div>

                                <p class="info-label">
                                    Booking Type
                                </p>

                                <p
                                    class="text-sm font-black text-[#17233C] uppercase"
                                >

                                    <?= e(
                                        $booking['booking_type']
                                    ) ?>

                                </p>

                            </div>


                            <div>

                                <p class="info-label">
                                    Amount
                                </p>

                                <p
                                    class="text-sm font-black text-[#17233C]"
                                >

                                    <?= formatAmount(
                                        $booking['amount']
                                    ) ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- ================================================= -->
                <!-- MANAGE BOOKING -->
                <!-- ================================================= -->

                <div class="card rounded-xl overflow-hidden">

                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <h2
                            class="text-sm font-extrabold text-[#17233C]"
                        >
                            Manage Booking
                        </h2>

                        <p class="text-[10px] text-slate-400 mt-0.5">
                            Update booking status
                        </p>

                    </div>


                    <form
                        method="POST"
                        class="p-4"
                    >

                        <label
                            class="block text-[9px] uppercase tracking-wider font-bold text-slate-500 mb-1.5"
                        >
                            Booking Status
                        </label>


                        <select
                            name="booking_status"
                            required
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-700 focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-50"
                        >

                            <option
                                value="pending"
                                <?= $booking['booking_status'] === 'pending'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Pending
                            </option>

                            <option
                                value="confirmed"
                                <?= $booking['booking_status'] === 'confirmed'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Confirmed
                            </option>

                            <option
                                value="completed"
                                <?= $booking['booking_status'] === 'completed'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                <?= $booking['booking_status'] === 'cancelled'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Cancelled
                            </option>

                        </select>


                        <button
                            type="submit"
                            class="mt-2.5 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#17233C] hover:bg-[#101a2e] text-white text-xs font-bold transition-colors"
                        >

                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />

                            </svg>

                            Update Status

                        </button>

                    </form>

                </div>


            </div>



            <!-- ===================================================== -->
            <!-- PAYMENT & BOOKING INFORMATION -->
            <!-- ===================================================== -->

            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-3"
            >


                <!-- ================================================= -->
                <!-- PAYMENT -->
                <!-- ================================================= -->

                <div class="card rounded-xl overflow-hidden">

                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <h2
                            class="text-sm font-extrabold text-[#17233C]"
                        >
                            Payment Information
                        </h2>

                        <p class="text-[10px] text-slate-400 mt-0.5">
                            Payment and Razorpay details
                        </p>

                    </div>


                    <div class="p-4">

                        <div
                            class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100"
                        >

                            <div>

                                <p class="info-label">
                                    Payment Status
                                </p>

                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[9px] font-bold uppercase <?= $paymentClass ?>"
                                >

                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-current"
                                    ></span>

                                    <?= ucfirst(
                                        e($booking['payment_status'])
                                    ) ?>

                                </span>

                            </div>


                            <div class="text-right">

                                <p class="info-label">
                                    Amount
                                </p>

                                <p
                                    class="text-base font-black text-[#17233C]"
                                >

                                    <?= formatAmount(
                                        $booking['amount']
                                    ) ?>

                                </p>

                            </div>

                        </div>


                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3"
                        >

                            <div>

                                <p class="info-label">
                                    Razorpay Order ID
                                </p>

                                <?php if (
                                    !empty(
                                        $booking['razorpay_order_id']
                                    )
                                ): ?>

                                    <p
                                        class="text-[11px] font-semibold text-slate-700 break-all"
                                    >

                                        <?= e(
                                            $booking['razorpay_order_id']
                                        ) ?>

                                    </p>

                                <?php else: ?>

                                    <p
                                        class="text-[11px] text-slate-400"
                                    >
                                        Not available
                                    </p>

                                <?php endif; ?>

                            </div>


                            <div>

                                <p class="info-label">
                                    Razorpay Payment ID
                                </p>

                                <?php if (
                                    !empty(
                                        $booking['razorpay_payment_id']
                                    )
                                ): ?>

                                    <p
                                        class="text-[11px] font-semibold text-slate-700 break-all"
                                    >

                                        <?= e(
                                            $booking['razorpay_payment_id']
                                        ) ?>

                                    </p>

                                <?php else: ?>

                                    <p
                                        class="text-[11px] text-slate-400"
                                    >
                                        Not available
                                    </p>

                                <?php endif; ?>

                            </div>


                            <div>

                                <p class="info-label">
                                    Payment Date
                                </p>

                                <p class="info-value">

                                    <?= formatDateTime(
                                        $booking['paid_at']
                                    ) ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- ================================================= -->
                <!-- BOOKING INFORMATION -->
                <!-- ================================================= -->

                <div class="card rounded-xl overflow-hidden">

                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <h2
                            class="text-sm font-extrabold text-[#17233C]"
                        >
                            Booking Information
                        </h2>

                        <p class="text-[10px] text-slate-400 mt-0.5">
                            Booking record details
                        </p>

                    </div>


                    <div class="p-4">

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4"
                        >

                            <div>

                                <p class="info-label">
                                    Booking ID
                                </p>

                                <p class="info-value">

                                    #<?= (int) $booking['id'] ?>

                                </p>

                            </div>


                            <div>

                                <p class="info-label">
                                    Booking Number
                                </p>

                                <p class="info-value break-all">

                                    <?= e(
                                        $booking['booking_number']
                                        ?: '-'
                                    ) ?>

                                </p>

                            </div>


                            <div>

                                <p class="info-label">
                                    Booking Type
                                </p>

                                <p class="info-value capitalize">

                                    <?= e(
                                        $booking['booking_type']
                                    ) ?>

                                </p>

                            </div>


                            <div>

                                <p class="info-label">
                                    Booking Date
                                </p>

                                <p class="info-value">

                                    <?= formatDateTime(
                                        $booking['created_at']
                                    ) ?>

                                </p>

                            </div>


                            <div>

                                <p class="info-label">
                                    Last Updated
                                </p>

                                <p class="info-value">

                                    <?= formatDateTime(
                                        $booking['updated_at']
                                    ) ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


            </div>


        </div>


    </main>


</div>


<?php include 'footer.php'; ?>


</body>

</html>