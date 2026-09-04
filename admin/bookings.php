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
| Filters
|--------------------------------------------------------------------------
*/

$search = trim($_GET['search'] ?? '');

$bookingStatus = trim($_GET['booking_status'] ?? '');

$paymentStatus = trim($_GET['payment_status'] ?? '');

$bookingType = trim($_GET['booking_type'] ?? '');

$dateFrom = trim($_GET['date_from'] ?? '');

$dateTo = trim($_GET['date_to'] ?? '');


/*
|--------------------------------------------------------------------------
| Allowed Filter Values
|--------------------------------------------------------------------------
*/

$allowedBookingStatuses = [
    'pending',
    'confirmed',
    'cancelled',
    'completed'
];

$allowedPaymentStatuses = [
    'pending',
    'paid',
    'failed',
    'refunded'
];

$allowedBookingTypes = [
    'rental',
    'purchase'
];


/*
|--------------------------------------------------------------------------
| Booking Query
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        b.id,
        b.booking_number,
        b.customer_name,
        b.mobile,
        b.email,
        b.city,
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

    INNER JOIN equipment e
        ON e.id = b.equipment_id

    WHERE 1 = 1
";

$params = [];


/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

if ($search !== '') {

    $sql .= "
        AND (
            b.booking_number LIKE ?
            OR b.customer_name LIKE ?
            OR b.mobile LIKE ?
            OR b.email LIKE ?
            OR e.name LIKE ?
        )
    ";

    $searchValue = '%' . $search . '%';

    $params[] = $searchValue;
    $params[] = $searchValue;
    $params[] = $searchValue;
    $params[] = $searchValue;
    $params[] = $searchValue;
}


/*
|--------------------------------------------------------------------------
| Booking Status
|--------------------------------------------------------------------------
*/

if (in_array($bookingStatus, $allowedBookingStatuses, true)) {

    $sql .= " AND b.booking_status = ? ";

    $params[] = $bookingStatus;
}


/*
|--------------------------------------------------------------------------
| Payment Status
|--------------------------------------------------------------------------
*/

if (in_array($paymentStatus, $allowedPaymentStatuses, true)) {

    $sql .= " AND b.payment_status = ? ";

    $params[] = $paymentStatus;
}


/*
|--------------------------------------------------------------------------
| Booking Type
|--------------------------------------------------------------------------
*/

if (in_array($bookingType, $allowedBookingTypes, true)) {

    $sql .= " AND b.booking_type = ? ";

    $params[] = $bookingType;
}


/*
|--------------------------------------------------------------------------
| Date From
|--------------------------------------------------------------------------
*/

if ($dateFrom !== '') {

    $sql .= " AND DATE(b.created_at) >= ? ";

    $params[] = $dateFrom;
}


/*
|--------------------------------------------------------------------------
| Date To
|--------------------------------------------------------------------------
*/

if ($dateTo !== '') {

    $sql .= " AND DATE(b.created_at) <= ? ";

    $params[] = $dateTo;
}


/*
|--------------------------------------------------------------------------
| Sort
|--------------------------------------------------------------------------
*/

$sql .= " ORDER BY b.created_at DESC ";


/*
|--------------------------------------------------------------------------
| Execute
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Total Bookings
|--------------------------------------------------------------------------
*/

$countStmt = $pdo->query("
    SELECT COUNT(*)
    FROM equipment_bookings
");

$totalBookings = (int) $countStmt->fetchColumn();


/*
|--------------------------------------------------------------------------
| Status Counts
|--------------------------------------------------------------------------
*/

$pendingStmt = $pdo->query("
    SELECT COUNT(*)
    FROM equipment_bookings
    WHERE booking_status = 'pending'
");

$pendingBookings = (int) $pendingStmt->fetchColumn();


$confirmedStmt = $pdo->query("
    SELECT COUNT(*)
    FROM equipment_bookings
    WHERE booking_status = 'confirmed'
");

$confirmedBookings = (int) $confirmedStmt->fetchColumn();


$completedStmt = $pdo->query("
    SELECT COUNT(*)
    FROM equipment_bookings
    WHERE booking_status = 'completed'
");

$completedBookings = (int) $completedStmt->fetchColumn();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Bookings | Jivhala Healthcare</title>

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
                linear-gradient(135deg,
                    #f8fafc 0%,
                    #f4f7fb 50%,
                    #f8fafc 100%);
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5eaf2;
            box-shadow:
                0 2px 8px rgba(15, 23, 42, 0.035);
        }

        .input-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .input-field:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
            outline: none;
        }

        .booking-row {
            transition:
                background-color 0.15s ease,
                box-shadow 0.15s ease;
        }

        .booking-row:hover {
            background: #f8fafc;
        }
    </style>

</head>


<body class="page-bg text-slate-800 antialiased min-h-screen">


    <?php include 'header.php'; ?>


    <div class="flex min-h-screen">


        <?php include 'sidebar.php'; ?>


        <!-- ========================================================= -->
        <!-- MAIN -->
        <!-- ========================================================= -->

        <main class="flex-1 overflow-x-hidden">


            <div
                class="max-w-[1450px] mx-auto px-4 sm:px-6 lg:px-8 py-5">


                <!-- ===================================================== -->
                <!-- PAGE HEADER -->
                <!-- ===================================================== -->

                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">


                    <div>

                        <div class="flex items-center gap-3">

                            <div
                                class="w-1 h-8 rounded-full bg-[#2563EB]"></div>

                            <div>

                                <h1
                                    class="text-2xl sm:text-3xl font-black tracking-tight text-[#17233C]">
                                    Bookings
                                </h1>

                                <p
                                    class="text-sm text-slate-500 mt-1">
                                    Manage equipment booking requests and customer orders.
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- Total -->

                    <div
                        class="card rounded-xl px-4 py-3 flex items-center gap-3 min-w-[160px]">

                        <div
                            class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24">

                                <rect
                                    x="5"
                                    y="4"
                                    width="14"
                                    height="17"
                                    rx="2" />

                                <path
                                    stroke-linecap="round"
                                    d="M9 8h6M9 12h6M9 16h4" />

                            </svg>

                        </div>


                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                Total Bookings
                            </p>

                            <p
                                class="text-xl font-black text-[#17233C] leading-none mt-1">
                                <?= $totalBookings ?>
                            </p>

                        </div>

                    </div>

                </div>



                <!-- ===================================================== -->
                <!-- SUMMARY -->
                <!-- ===================================================== -->

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">


                    <!-- Pending -->

                    <div class="card rounded-xl px-4 py-3">

                        <div class="flex items-center justify-between">

                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                    Pending
                                </p>

                                <p
                                    class="text-2xl font-black text-[#17233C] mt-1">
                                    <?= $pendingBookings ?>
                                </p>

                            </div>

                            <div
                                class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="8" />

                                    <path
                                        stroke-linecap="round"
                                        d="M12 7v5l3 2" />

                                </svg>

                            </div>

                        </div>

                    </div>


                    <!-- Confirmed -->

                    <div class="card rounded-xl px-4 py-3">

                        <div class="flex items-center justify-between">

                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                    Confirmed
                                </p>

                                <p
                                    class="text-2xl font-black text-[#17233C] mt-1">
                                    <?= $confirmedBookings ?>
                                </p>

                            </div>

                            <div
                                class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12l4 4L19 6" />

                                </svg>

                            </div>

                        </div>

                    </div>


                    <!-- Completed -->

                    <div class="card rounded-xl px-4 py-3">

                        <div class="flex items-center justify-between">

                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                    Completed
                                </p>

                                <p
                                    class="text-2xl font-black text-[#17233C] mt-1">
                                    <?= $completedBookings ?>
                                </p>

                            </div>

                            <div
                                class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="8" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12l2 2 4-4" />

                                </svg>

                            </div>

                        </div>

                    </div>


                </div>



                <!-- ===================================================== -->
                <!-- FILTER CARD -->
                <!-- ===================================================== -->

                <div
                    class="card rounded-xl overflow-hidden mb-5">


                    <!-- Header -->

                    <div
                        class="px-4 sm:px-5 py-3 border-b border-slate-100 flex items-center justify-between">

                        <div>

                            <h2
                                class="text-base font-extrabold text-[#17233C]">
                                Search & Filters
                            </h2>

                            <p
                                class="text-xs text-slate-400 mt-0.5">
                                Find specific booking records
                            </p>

                        </div>


                        <div
                            class="text-xs font-semibold text-slate-400">

                            <?= count($bookings) ?> results

                        </div>

                    </div>


                    <!-- Form -->

                    <form
                        method="GET"
                        action="bookings.php"
                        class="p-4 sm:p-5">


                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3">


                            <!-- Search -->

                            <div class="lg:col-span-2">

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    Search
                                </label>

                                <div class="relative">

                                    <svg
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <circle
                                            cx="11"
                                            cy="11"
                                            r="7" />

                                        <path
                                            stroke-linecap="round"
                                            d="m20 20-4-4" />

                                    </svg>

                                    <input
                                        type="text"
                                        name="search"
                                        value="<?= htmlspecialchars($search) ?>"
                                        placeholder="Booking no., customer, mobile..."
                                        class="input-field w-full pl-9 pr-3 py-2.5 rounded-lg text-sm text-slate-700 placeholder-slate-400">

                                </div>

                            </div>


                            <!-- Booking Status -->

                            <div>

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    Booking Status
                                </label>

                                <select
                                    name="booking_status"
                                    class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700">

                                    <option value="">
                                        All Statuses
                                    </option>

                                    <option
                                        value="pending"
                                        <?= $bookingStatus === 'pending' ? 'selected' : '' ?>>
                                        Pending
                                    </option>

                                    <option
                                        value="confirmed"
                                        <?= $bookingStatus === 'confirmed' ? 'selected' : '' ?>>
                                        Confirmed
                                    </option>

                                    <option
                                        value="cancelled"
                                        <?= $bookingStatus === 'cancelled' ? 'selected' : '' ?>>
                                        Cancelled
                                    </option>

                                    <option
                                        value="completed"
                                        <?= $bookingStatus === 'completed' ? 'selected' : '' ?>>
                                        Completed
                                    </option>

                                </select>

                            </div>


                            <!-- Payment -->

                            <div>

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    Payment
                                </label>

                                <select
                                    name="payment_status"
                                    class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700">

                                    <option value="">
                                        All Payments
                                    </option>

                                    <option
                                        value="pending"
                                        <?= $paymentStatus === 'pending' ? 'selected' : '' ?>>
                                        Pending
                                    </option>

                                    <option
                                        value="paid"
                                        <?= $paymentStatus === 'paid' ? 'selected' : '' ?>>
                                        Paid
                                    </option>

                                    <option
                                        value="failed"
                                        <?= $paymentStatus === 'failed' ? 'selected' : '' ?>>
                                        Failed
                                    </option>

                                    <option
                                        value="refunded"
                                        <?= $paymentStatus === 'refunded' ? 'selected' : '' ?>>
                                        Refunded
                                    </option>

                                </select>

                            </div>


                            <!-- Type -->

                            <div>

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    Type
                                </label>

                                <select
                                    name="booking_type"
                                    class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700">

                                    <option value="">
                                        All Types
                                    </option>

                                    <option
                                        value="rental"
                                        <?= $bookingType === 'rental' ? 'selected' : '' ?>>
                                        Rental
                                    </option>

                                    <option
                                        value="purchase"
                                        <?= $bookingType === 'purchase' ? 'selected' : '' ?>>
                                        Purchase
                                    </option>

                                </select>

                            </div>


                            <!-- From -->

                            <div>

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    From
                                </label>

                                <input
                                    type="date"
                                    name="date_from"
                                    value="<?= htmlspecialchars($dateFrom) ?>"
                                    class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700">

                            </div>


                            <!-- To -->

                            <div>

                                <label
                                    class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5">
                                    To
                                </label>

                                <input
                                    type="date"
                                    name="date_to"
                                    value="<?= htmlspecialchars($dateTo) ?>"
                                    class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700">

                            </div>


                        </div>


                        <!-- Buttons -->

                        <div
                            class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-100">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#17233C] hover:bg-[#101a2e] text-white rounded-lg text-sm font-bold transition-colors shadow-sm">

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="7" />

                                    <path
                                        stroke-linecap="round"
                                        d="m20 20-4-4" />

                                </svg>

                                Apply Filters

                            </button>


                            <a
                                href="bookings.php"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg text-sm font-semibold transition-colors">

                                Reset

                            </a>

                        </div>


                    </form>

                </div>



                <!-- ===================================================== -->
                <!-- BOOKING RECORDS -->
                <!-- ===================================================== -->

                <div>


                    <!-- Heading -->

                    <div
                        class="flex items-end justify-between mb-3">

                        <div>

                            <div class="flex items-center gap-2">

                                <h2
                                    class="text-xl font-black text-[#17233C]">
                                    Booking Records
                                </h2>

                                <span
                                    class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">
                                    <?= count($bookings) ?>
                                </span>

                            </div>

                            <p
                                class="text-xs text-slate-400 mt-1">
                                Latest booking requests and orders
                            </p>

                        </div>

                    </div>



                    <!-- ================================================= -->
                    <!-- DESKTOP TABLE -->
                    <!-- ================================================= -->

                    <div
                        class="hidden md:block card rounded-xl overflow-hidden">

                        <div class="overflow-x-auto">

                            <table class="w-full">


                                <thead
                                    class="bg-[#F8FAFC] border-b border-slate-200">

                                    <tr>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Booking
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Customer
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Equipment
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Type
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Amount
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Payment
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Status
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Date
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody
                                    class="divide-y divide-slate-100">


                                    <?php if (empty($bookings)): ?>


                                        <tr>

                                            <td
                                                colspan="9"
                                                class="px-6 py-12 text-center">

                                                <div
                                                    class="w-11 h-11 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">

                                                    <svg
                                                        class="w-5 h-5"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />

                                                    </svg>

                                                </div>

                                                <p
                                                    class="font-bold text-slate-700">
                                                    No bookings found
                                                </p>

                                                <p
                                                    class="text-xs text-slate-400 mt-1">
                                                    Try changing your search or filters.
                                                </p>

                                            </td>

                                        </tr>


                                    <?php else: ?>


                                        <?php foreach ($bookings as $booking): ?>


                                            <tr class="booking-row">


                                                <!-- Booking -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <p
                                                        class="font-extrabold text-[#17233C] text-sm">
                                                        <?= htmlspecialchars(
                                                            $booking['booking_number'] ?: 'N/A'
                                                        ) ?>
                                                    </p>

                                                    <p
                                                        class="text-[10px] text-slate-400 mt-0.5">
                                                        ID #<?= (int) $booking['id'] ?>
                                                    </p>

                                                </td>


                                                <!-- Customer -->

                                                <td
                                                    class="px-4 py-3">

                                                    <p
                                                        class="font-bold text-slate-800 text-sm">
                                                        <?= htmlspecialchars(
                                                            $booking['customer_name']
                                                        ) ?>
                                                    </p>

                                                    <p
                                                        class="text-[11px] text-slate-500 mt-0.5">
                                                        <?= htmlspecialchars(
                                                            $booking['mobile']
                                                        ) ?>
                                                    </p>

                                                </td>


                                                <!-- Equipment -->

                                                <td
                                                    class="px-4 py-3 min-w-[210px]">

                                                    <p
                                                        class="font-bold text-slate-800 text-sm leading-snug">
                                                        <?= htmlspecialchars(
                                                            $booking['equipment_name']
                                                        ) ?>
                                                    </p>

                                                    <p
                                                        class="text-[10px] text-slate-400 mt-0.5">
                                                        <?= htmlspecialchars(
                                                            $booking['city']
                                                        ) ?>
                                                    </p>

                                                </td>


                                                <!-- Type -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase">

                                                        <?= ucfirst(
                                                            htmlspecialchars(
                                                                $booking['booking_type']
                                                            )
                                                        ) ?>

                                                    </span>

                                                </td>


                                                <!-- Amount -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <?php if (
                                                        $booking['amount'] !== null &&
                                                        $booking['amount'] !== ''
                                                    ): ?>

                                                        <p
                                                            class="font-black text-[#17233C]">
                                                            ₹<?= number_format(
                                                                    (float) $booking['amount'],
                                                                    2
                                                                ) ?>
                                                        </p>

                                                    <?php else: ?>

                                                        <span
                                                            class="text-xs text-slate-400">
                                                            Contact Us
                                                        </span>

                                                    <?php endif; ?>

                                                </td>


                                                <!-- Payment -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase">

                                                        <?= ucfirst(
                                                            htmlspecialchars(
                                                                $booking['payment_status']
                                                            )
                                                        ) ?>

                                                    </span>

                                                </td>


                                                <!-- Status -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <?php

                                                    $statusText = ucfirst(
                                                        htmlspecialchars(
                                                            $booking['booking_status']
                                                        )
                                                    );

                                                    ?>

                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase
                                                <?= $booking['booking_status'] === 'confirmed'
                                                    ? 'bg-blue-50 text-blue-700'
                                                    : 'bg-slate-100 text-slate-600'
                                                ?>">

                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full bg-current"></span>

                                                        <?= $statusText ?>

                                                    </span>

                                                </td>


                                                <!-- Date -->

                                                <td
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <p
                                                        class="text-xs font-semibold text-slate-700">

                                                        <?= date(
                                                            'd M Y',
                                                            strtotime(
                                                                $booking['created_at']
                                                            )
                                                        ) ?>

                                                    </p>

                                                    <p
                                                        class="text-[10px] text-slate-400 mt-0.5">

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
                                                    class="px-4 py-3 whitespace-nowrap">

                                                    <a
                                                        href="booking-details.php?id=<?= (int) $booking['id'] ?>"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#17233C] hover:bg-[#101a2e] text-white text-[11px] font-bold transition-colors">

                                                        View

                                                        <svg
                                                            class="w-3.5 h-3.5"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                            viewBox="0 0 24 24">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M9 5l7 7-7 7" />

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
                    <!-- MOBILE -->
                    <!-- ================================================= -->

                    <div class="md:hidden space-y-3">


                        <?php if (empty($bookings)): ?>


                            <div
                                class="card rounded-xl p-8 text-center">

                                <p class="font-bold text-slate-700">
                                    No bookings found
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    Try changing your filters.
                                </p>

                            </div>


                        <?php else: ?>


                            <?php foreach ($bookings as $booking): ?>


                                <article
                                    class="card rounded-xl overflow-hidden">


                                    <!-- Header -->

                                    <div
                                        class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between gap-3">

                                        <div>

                                            <p
                                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                Booking
                                            </p>

                                            <p
                                                class="font-black text-[#17233C] text-sm mt-0.5">

                                                <?= htmlspecialchars(
                                                    $booking['booking_number'] ?: 'N/A'
                                                ) ?>

                                            </p>

                                        </div>


                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[9px] font-bold uppercase
                                    <?= $booking['booking_status'] === 'confirmed'
                                        ? 'bg-blue-50 text-blue-700'
                                        : 'bg-slate-100 text-slate-600'
                                    ?>">

                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-current"></span>

                                            <?= ucfirst(
                                                htmlspecialchars(
                                                    $booking['booking_status']
                                                )
                                            ) ?>

                                        </span>

                                    </div>


                                    <!-- Body -->

                                    <div class="p-4">


                                        <div class="mb-4">

                                            <p
                                                class="font-bold text-slate-800 text-sm">

                                                <?= htmlspecialchars(
                                                    $booking['customer_name']
                                                ) ?>

                                            </p>

                                            <p
                                                class="text-xs text-slate-500 mt-0.5">

                                                <?= htmlspecialchars(
                                                    $booking['mobile']
                                                ) ?>

                                            </p>

                                        </div>


                                        <div
                                            class="bg-slate-50 rounded-lg p-3 mb-3">

                                            <p
                                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                Equipment
                                            </p>

                                            <p
                                                class="font-bold text-slate-800 text-sm mt-1">

                                                <?= htmlspecialchars(
                                                    $booking['equipment_name']
                                                ) ?>

                                            </p>

                                            <p
                                                class="text-xs text-slate-400 mt-0.5">

                                                <?= htmlspecialchars(
                                                    $booking['city']
                                                ) ?>

                                            </p>

                                        </div>


                                        <div
                                            class="grid grid-cols-2 gap-3">


                                            <div>

                                                <p
                                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                    Type
                                                </p>

                                                <p
                                                    class="text-sm font-bold text-slate-700 mt-1">

                                                    <?= ucfirst(
                                                        htmlspecialchars(
                                                            $booking['booking_type']
                                                        )
                                                    ) ?>

                                                </p>

                                            </div>


                                            <div>

                                                <p
                                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                    Amount
                                                </p>

                                                <p
                                                    class="text-sm font-black text-[#17233C] mt-1">

                                                    <?php if (
                                                        $booking['amount'] !== null &&
                                                        $booking['amount'] !== ''
                                                    ): ?>

                                                        ₹<?= number_format(
                                                                (float) $booking['amount'],
                                                                2
                                                            ) ?>

                                                    <?php else: ?>

                                                        Contact Us

                                                    <?php endif; ?>

                                                </p>

                                            </div>


                                            <div>

                                                <p
                                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                    Payment
                                                </p>

                                                <p
                                                    class="text-xs font-semibold text-slate-600 mt-1">

                                                    <?= ucfirst(
                                                        htmlspecialchars(
                                                            $booking['payment_status']
                                                        )
                                                    ) ?>

                                                </p>

                                            </div>


                                            <div>

                                                <p
                                                    class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                                    Date
                                                </p>

                                                <p
                                                    class="text-xs font-semibold text-slate-700 mt-1">

                                                    <?= date(
                                                        'd M Y',
                                                        strtotime(
                                                            $booking['created_at']
                                                        )
                                                    ) ?>

                                                </p>

                                            </div>


                                        </div>


                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-100">

                                        <a
                                            href="booking-details.php?id=<?= (int) $booking['id'] ?>"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#17233C] hover:bg-[#101a2e] text-white text-xs font-bold transition-colors">

                                            View Booking

                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                viewBox="0 0 24 24">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 5l7 7-7 7" />

                                            </svg>

                                        </a>

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