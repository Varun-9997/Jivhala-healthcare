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
| Customer ID
|--------------------------------------------------------------------------
*/

$customerId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($customerId <= 0) {
    header("Location: customers.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Customer
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        customer_number,
        name,
        mobile,
        email,
        city,
        status,
        created_at,
        updated_at
    FROM customers
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$customerId]);

$customer = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$customer) {
    header("Location: customers.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Booking Summary
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        COUNT(*) AS total_bookings,

        SUM(
            CASE
                WHEN booking_status = 'pending'
                THEN 1
                ELSE 0
            END
        ) AS pending_bookings,

        SUM(
            CASE
                WHEN booking_status = 'confirmed'
                THEN 1
                ELSE 0
            END
        ) AS confirmed_bookings,

        SUM(
            CASE
                WHEN booking_status = 'completed'
                THEN 1
                ELSE 0
            END
        ) AS completed_bookings,

        SUM(
            CASE
                WHEN booking_status = 'cancelled'
                THEN 1
                ELSE 0
            END
        ) AS cancelled_bookings

    FROM equipment_bookings
    WHERE customer_id = ?
");

$stmt->execute([$customerId]);

$summary = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Booking History
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        b.id,
        b.booking_number,
        b.booking_type,
        b.amount,
        b.booking_status,
        b.payment_status,
        b.razorpay_order_id,
        b.razorpay_payment_id,
        b.paid_at,
        b.created_at,

        e.name AS equipment_name

    FROM equipment_bookings b

    LEFT JOIN equipment e
        ON e.id = b.equipment_id

    WHERE b.customer_id = ?

    ORDER BY b.created_at DESC
");

$stmt->execute([$customerId]);

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
*/

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


function bookingStatusClass($status)
{
    return match (strtolower((string) $status)) {

        'confirmed' =>
            'bg-blue-50 text-blue-700',

        'completed' =>
            'bg-slate-100 text-slate-700',

        'cancelled' =>
            'bg-slate-100 text-slate-500',

        default =>
            'bg-slate-100 text-slate-600'
    };
}


function paymentStatusClass($status)
{
    return match (strtolower((string) $status)) {

        'paid' =>
            'bg-blue-50 text-blue-700',

        'failed' =>
            'bg-slate-100 text-slate-500',

        default =>
            'bg-slate-100 text-slate-600'
    };
}

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
        <?= htmlspecialchars($customer['name']) ?>
        | Customer Details
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


        .booking-row {
            transition:
                background-color 0.15s ease;
        }


        .booking-row:hover {
            background: #f8fafc;
        }


        .info-label {
            font-size: 9px;
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


<div
    class="flex min-h-[calc(100vh-5rem)]"
>


    <?php include 'sidebar.php'; ?>


    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <main class="flex-1 overflow-x-hidden">


        <div
            class="max-w-[1450px] mx-auto px-4 sm:px-6 lg:px-8 py-4"
        >


            <!-- ===================================================== -->
            <!-- TOP HEADER -->
            <!-- ===================================================== -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4"
            >


                <div>


                    <!-- Back -->

                    <a
                        href="customers.php"
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

                        Back to Customers

                    </a>


                    <div class="flex items-center gap-3">


                        <div
                            class="w-1 h-9 rounded-full bg-teal-500"
                        ></div>


                        <div>

                            <p
                                class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                            >
                                Customer Profile
                            </p>


                            <h1
                                class="text-xl sm:text-2xl font-black tracking-tight text-[#17233C]"
                            >

                                <?= htmlspecialchars(
                                    $customer['name']
                                ) ?>

                            </h1>


                            <p
                                class="text-xs text-slate-500 mt-0.5"
                            >

                                <?= htmlspecialchars(
                                    $customer['customer_number']
                                ) ?>

                            </p>

                        </div>

                    </div>

                </div>


                <!-- Status -->

                <div>

                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase
                        <?= $customer['status'] === 'active'
                            ? 'bg-blue-50 text-blue-700'
                            : 'bg-slate-100 text-slate-500'
                        ?>"
                    >

                        <span
                            class="w-1.5 h-1.5 rounded-full bg-current"
                        ></span>

                        <?= htmlspecialchars(
                            $customer['status']
                        ) ?>

                    </span>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- CUSTOMER + BOOKING SUMMARY -->
            <!-- ===================================================== -->

            <div
                class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-3"
            >


                <!-- ================================================= -->
                <!-- CUSTOMER INFORMATION -->
                <!-- ================================================= -->

                <div
                    class="lg:col-span-2 card rounded-xl overflow-hidden"
                >


                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <h2
                            class="text-sm font-extrabold text-[#17233C]"
                        >
                            Customer Information
                        </h2>

                        <p
                            class="text-[10px] text-slate-400 mt-0.5"
                        >
                            Registered customer details
                        </p>

                    </div>


                    <div
                        class="p-4 grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4"
                    >


                        <!-- Customer Number -->

                        <div>

                            <p class="info-label">
                                Customer Number
                            </p>

                            <p class="info-value">

                                <?= htmlspecialchars(
                                    $customer['customer_number']
                                ) ?>

                            </p>

                        </div>


                        <!-- Full Name -->

                        <div>

                            <p class="info-label">
                                Full Name
                            </p>

                            <p class="info-value">

                                <?= htmlspecialchars(
                                    $customer['name']
                                ) ?>

                            </p>

                        </div>


                        <!-- Mobile -->

                        <div>

                            <p class="info-label">
                                Mobile
                            </p>

                            <p class="info-value">

                                <?= htmlspecialchars(
                                    $customer['mobile']
                                ) ?>

                            </p>

                        </div>


                        <!-- Email -->

                        <div class="col-span-2 sm:col-span-1">

                            <p class="info-label">
                                Email
                            </p>

                            <?php if (
                                !empty($customer['email'])
                            ): ?>

                                <p
                                    class="info-value break-all"
                                >

                                    <?= htmlspecialchars(
                                        $customer['email']
                                    ) ?>

                                </p>

                            <?php else: ?>

                                <p
                                    class="text-xs text-slate-400"
                                >
                                    Not provided
                                </p>

                            <?php endif; ?>

                        </div>


                        <!-- City -->

                        <div>

                            <p class="info-label">
                                City
                            </p>

                            <p class="info-value">

                                <?= htmlspecialchars(
                                    $customer['city']
                                ) ?>

                            </p>

                        </div>


                        <!-- Customer Since -->

                        <div>

                            <p class="info-label">
                                Customer Since
                            </p>

                            <p class="info-value">

                                <?= formatDateTime(
                                    $customer['created_at']
                                ) ?>

                            </p>

                        </div>


                    </div>

                </div>



                <!-- ================================================= -->
                <!-- BOOKING OVERVIEW -->
                <!-- ================================================= -->

                <div
                    class="card rounded-xl overflow-hidden"
                >


                    <div
                        class="px-4 py-3 border-b border-slate-100"
                    >

                        <h2
                            class="text-sm font-extrabold text-[#17233C]"
                        >
                            Booking Overview
                        </h2>

                        <p
                            class="text-[10px] text-slate-400 mt-0.5"
                        >
                            Customer activity
                        </p>

                    </div>


                    <div class="p-4">


                        <div
                            class="grid grid-cols-2 gap-2"
                        >


                            <!-- Total -->

                            <div
                                class="rounded-lg bg-slate-50 border border-slate-100 p-3"
                            >

                                <p
                                    class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                                >
                                    Total
                                </p>

                                <p
                                    class="text-xl font-black text-[#17233C] mt-1"
                                >

                                    <?= (int) (
                                        $summary['total_bookings']
                                        ?? 0
                                    ) ?>

                                </p>

                            </div>


                            <!-- Pending -->

                            <div
                                class="rounded-lg bg-slate-50 border border-slate-100 p-3"
                            >

                                <p
                                    class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                                >
                                    Pending
                                </p>

                                <p
                                    class="text-xl font-black text-slate-700 mt-1"
                                >

                                    <?= (int) (
                                        $summary['pending_bookings']
                                        ?? 0
                                    ) ?>

                                </p>

                            </div>


                            <!-- Confirmed -->

                            <div
                                class="rounded-lg bg-slate-50 border border-slate-100 p-3"
                            >

                                <p
                                    class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                                >
                                    Confirmed
                                </p>

                                <p
                                    class="text-xl font-black text-blue-700 mt-1"
                                >

                                    <?= (int) (
                                        $summary['confirmed_bookings']
                                        ?? 0
                                    ) ?>

                                </p>

                            </div>


                            <!-- Completed -->

                            <div
                                class="rounded-lg bg-slate-50 border border-slate-100 p-3"
                            >

                                <p
                                    class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                                >
                                    Completed
                                </p>

                                <p
                                    class="text-xl font-black text-slate-700 mt-1"
                                >

                                    <?= (int) (
                                        $summary['completed_bookings']
                                        ?? 0
                                    ) ?>

                                </p>

                            </div>


                            <!-- Cancelled -->

                            <div
                                class="col-span-2 rounded-lg bg-slate-50 border border-slate-100 p-3 flex items-center justify-between"
                            >

                                <p
                                    class="text-[9px] uppercase tracking-wider font-bold text-slate-400"
                                >
                                    Cancelled
                                </p>

                                <p
                                    class="text-lg font-black text-slate-500"
                                >

                                    <?= (int) (
                                        $summary['cancelled_bookings']
                                        ?? 0
                                    ) ?>

                                </p>

                            </div>


                        </div>

                    </div>

                </div>


            </div>



            <!-- ===================================================== -->
            <!-- BOOKING HISTORY -->
            <!-- ===================================================== -->

            <div>


                <div
                    class="flex items-center justify-between gap-3 mb-2"
                >

                    <div>

                        <h2
                            class="text-lg font-black text-[#17233C]"
                        >
                            Booking History
                        </h2>

                        <p
                            class="text-[10px] text-slate-400 mt-0.5"
                        >
                            All bookings associated with this customer
                        </p>

                    </div>


                    <span
                        class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold whitespace-nowrap"
                    >

                        <?= count($bookings) ?> bookings

                    </span>

                </div>



                <!-- ================================================= -->
                <!-- DESKTOP TABLE -->
                <!-- ================================================= -->

                <div
                    class="hidden md:block card rounded-xl overflow-hidden"
                >

                    <div class="overflow-x-auto">

                        <table class="w-full">


                            <thead
                                class="bg-slate-50 border-b border-slate-200"
                            >

                                <tr>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Booking
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Equipment
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Type
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Amount
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Status
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-left text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Date
                                    </th>


                                    <th
                                        class="px-4 py-2.5 text-right text-[9px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Action
                                    </th>


                                </tr>

                            </thead>


                            <tbody
                                class="divide-y divide-slate-100"
                            >


                            <?php if (empty($bookings)): ?>


                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-6 py-10 text-center"
                                    >

                                        <p
                                            class="font-bold text-sm text-slate-700"
                                        >
                                            No bookings yet
                                        </p>

                                        <p
                                            class="text-xs text-slate-400 mt-1"
                                        >
                                            This customer has no booking history.
                                        </p>

                                    </td>

                                </tr>


                            <?php else: ?>


                                <?php foreach (
                                    $bookings as $booking
                                ): ?>


                                    <tr
                                        class="booking-row"
                                    >


                                        <!-- Booking -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="text-xs font-bold text-[#17233C]"
                                            >

                                                <?= htmlspecialchars(
                                                    $booking['booking_number']
                                                    ?: 'JIV-' . str_pad(
                                                        $booking['id'],
                                                        5,
                                                        '0',
                                                        STR_PAD_LEFT
                                                    )
                                                ) ?>

                                            </p>

                                        </td>


                                        <!-- Equipment -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="text-xs font-semibold text-slate-700 max-w-[230px]"
                                            >

                                                <?= htmlspecialchars(
                                                    $booking['equipment_name']
                                                    ?: 'Equipment unavailable'
                                                ) ?>

                                            </p>

                                        </td>


                                        <!-- Type -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <span
                                                class="text-[10px] font-bold uppercase text-slate-600"
                                            >

                                                <?= htmlspecialchars(
                                                    $booking['booking_type']
                                                ) ?>

                                            </span>

                                        </td>


                                        <!-- Amount -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="text-xs font-black text-[#17233C]"
                                            >

                                                <?= formatAmount(
                                                    $booking['amount']
                                                ) ?>

                                            </p>

                                        </td>


                                        <!-- Status -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <span
                                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[9px] font-bold uppercase <?= bookingStatusClass(
                                                    $booking['booking_status']
                                                ) ?>"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-current"
                                                ></span>

                                                <?= htmlspecialchars(
                                                    $booking['booking_status']
                                                ) ?>

                                            </span>

                                        </td>


                                        <!-- Date -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="text-[11px] font-semibold text-slate-700"
                                            >

                                                <?= date(
                                                    'd M Y',
                                                    strtotime(
                                                        $booking['created_at']
                                                    )
                                                ) ?>

                                            </p>

                                            <p
                                                class="text-[9px] text-slate-400 mt-0.5"
                                            >

                                                <?= date(
                                                    'h:i A',
                                                    strtotime(
                                                        $booking['created_at']
                                                    )
                                                ) ?>

                                            </p>

                                        </td>


                                        <!-- Action -->

                                        <td
                                            class="px-4 py-3 text-right"
                                        >

                                            <a
                                                href="booking-details.php?id=<?= (int) $booking['id'] ?>"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md bg-[#17233C] hover:bg-[#101a2e] text-white text-[9px] font-bold transition-colors"
                                            >

                                                View

                                                <svg
                                                    class="w-3 h-3"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 5l7 7-7 7"
                                                    />

                                                </svg>

                                            </a>

                                        </td>


                                    </tr>


                                <?php endforeach; ?>


                            <?php endif; ?>


                            </tbody>

                        </table>

                    </div>

                </div>



                <!-- ================================================= -->
                <!-- MOBILE BOOKING CARDS -->
                <!-- ================================================= -->

                <div
                    class="md:hidden space-y-2.5"
                >


                <?php if (empty($bookings)): ?>


                    <div
                        class="card rounded-xl p-7 text-center"
                    >

                        <p
                            class="font-bold text-sm text-slate-700"
                        >
                            No bookings yet
                        </p>

                        <p
                            class="text-xs text-slate-400 mt-1"
                        >
                            This customer has no booking history.
                        </p>

                    </div>


                <?php else: ?>


                    <?php foreach (
                        $bookings as $booking
                    ): ?>


                        <article
                            class="card rounded-xl overflow-hidden"
                        >


                            <!-- Card Header -->

                            <div
                                class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between gap-3"
                            >

                                <div>

                                    <p
                                        class="text-xs font-black text-[#17233C]"
                                    >

                                        <?= htmlspecialchars(
                                            $booking['booking_number']
                                            ?: 'JIV-' . str_pad(
                                                $booking['id'],
                                                5,
                                                '0',
                                                STR_PAD_LEFT
                                            )
                                        ) ?>

                                    </p>

                                    <p
                                        class="text-[9px] text-slate-400 mt-0.5"
                                    >

                                        <?= date(
                                            'd M Y, h:i A',
                                            strtotime(
                                                $booking['created_at']
                                            )
                                        ) ?>

                                    </p>

                                </div>


                                <span
                                    class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[9px] font-bold uppercase <?= bookingStatusClass(
                                        $booking['booking_status']
                                    ) ?>"
                                >

                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-current"
                                    ></span>

                                    <?= htmlspecialchars(
                                        $booking['booking_status']
                                    ) ?>

                                </span>

                            </div>


                            <!-- Card Body -->

                            <div class="p-4">


                                <div
                                    class="mb-3"
                                >

                                    <p class="info-label">
                                        Equipment
                                    </p>

                                    <p
                                        class="text-sm font-bold text-[#17233C] leading-snug"
                                    >

                                        <?= htmlspecialchars(
                                            $booking['equipment_name']
                                            ?: 'Equipment unavailable'
                                        ) ?>

                                    </p>

                                </div>


                                <div
                                    class="grid grid-cols-2 gap-4"
                                >


                                    <div>

                                        <p class="info-label">
                                            Booking Type
                                        </p>

                                        <p
                                            class="text-xs font-bold uppercase text-slate-700"
                                        >

                                            <?= htmlspecialchars(
                                                $booking['booking_type']
                                            ) ?>

                                        </p>

                                    </div>


                                    <div>

                                        <p class="info-label">
                                            Amount
                                        </p>

                                        <p
                                            class="text-xs font-black text-[#17233C]"
                                        >

                                            <?= formatAmount(
                                                $booking['amount']
                                            ) ?>

                                        </p>

                                    </div>


                                </div>


                                <div
                                    class="mt-3 pt-3 border-t border-slate-100 flex justify-end"
                                >

                                    <a
                                        href="booking-details.php?id=<?= (int) $booking['id'] ?>"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-[#17233C] hover:bg-[#101a2e] text-white text-[10px] font-bold transition-colors"
                                    >

                                        View Booking

                                        <svg
                                            class="w-3 h-3"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 5l7 7-7 7"
                                            />

                                        </svg>

                                    </a>

                                </div>


                            </div>


                        </article>


                    <?php endforeach; ?>


                <?php endif; ?>


                </div>


            </div>


        </div>


    </main>


</div>


<?php include 'footer.php'; ?>


</body>

</html>