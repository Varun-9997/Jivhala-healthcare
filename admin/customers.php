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

$city = trim($_GET['city'] ?? '');

$status = trim($_GET['status'] ?? '');


/*
|--------------------------------------------------------------------------
| Allowed Status
|--------------------------------------------------------------------------
*/

$allowedStatuses = [
    'active',
    'inactive'
];


/*
|--------------------------------------------------------------------------
| Customer Query
|--------------------------------------------------------------------------
|
| Booking statistics are calculated from equipment_bookings.
|
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        c.id,
        c.customer_number,
        c.name,
        c.mobile,
        c.email,
        c.city,
        c.status,
        c.created_at,

        COUNT(b.id) AS total_bookings,

        MAX(b.created_at) AS last_booking

    FROM customers c

    LEFT JOIN equipment_bookings b
        ON b.customer_id = c.id

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
            c.customer_number LIKE ?
            OR c.name LIKE ?
            OR c.mobile LIKE ?
            OR c.email LIKE ?
        )
    ";

    $searchValue = '%' . $search . '%';

    $params[] = $searchValue;
    $params[] = $searchValue;
    $params[] = $searchValue;
    $params[] = $searchValue;
}


/*
|--------------------------------------------------------------------------
| City Filter
|--------------------------------------------------------------------------
*/

if ($city !== '') {

    $sql .= " AND c.city = ? ";

    $params[] = $city;
}


/*
|--------------------------------------------------------------------------
| Status Filter
|--------------------------------------------------------------------------
*/

if (in_array($status, $allowedStatuses, true)) {

    $sql .= " AND c.status = ? ";

    $params[] = $status;
}


/*
|--------------------------------------------------------------------------
| Group
|--------------------------------------------------------------------------
*/

$sql .= "
    GROUP BY
        c.id,
        c.customer_number,
        c.name,
        c.mobile,
        c.email,
        c.city,
        c.status,
        c.created_at
";


/*
|--------------------------------------------------------------------------
| Sort
|--------------------------------------------------------------------------
*/

$sql .= "
    ORDER BY
        CASE
            WHEN last_booking IS NOT NULL THEN 0
            ELSE 1
        END,
        last_booking DESC,
        c.created_at DESC
";


/*
|--------------------------------------------------------------------------
| Execute
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Summary Counts
|--------------------------------------------------------------------------
*/

$totalCustomersStmt = $pdo->query("
    SELECT COUNT(*)
    FROM customers
");

$totalCustomers = (int) $totalCustomersStmt->fetchColumn();


$activeCustomersStmt = $pdo->query("
    SELECT COUNT(*)
    FROM customers
    WHERE status = 'active'
");

$activeCustomers = (int) $activeCustomersStmt->fetchColumn();


$inactiveCustomersStmt = $pdo->query("
    SELECT COUNT(*)
    FROM customers
    WHERE status = 'inactive'
");

$inactiveCustomers = (int) $inactiveCustomersStmt->fetchColumn();


$bookingCustomersStmt = $pdo->query("
    SELECT COUNT(DISTINCT customer_id)
    FROM equipment_bookings
    WHERE customer_id IS NOT NULL
");

$bookingCustomers = (int) $bookingCustomersStmt->fetchColumn();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Customers | Jivhala Healthcare</title>

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

        .input-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .input-field:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.08);
            outline: none;
        }

        .customer-row {
            transition:
                background-color 0.15s ease;
        }

        .customer-row:hover {
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
            class="max-w-[1450px] mx-auto px-4 sm:px-6 lg:px-8 py-5"
        >


            <!-- ===================================================== -->
            <!-- PAGE HEADER -->
            <!-- ===================================================== -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5"
            >


                <div>

                    <div class="flex items-center gap-3">

                        <div
                            class="w-1 h-8 rounded-full bg-[#2563EB]"
                        ></div>

                        <div>

                            <h1
                                class="text-2xl sm:text-3xl font-black tracking-tight text-[#17233C]"
                            >
                                Customers
                            </h1>

                            <p
                                class="text-sm text-slate-500 mt-1"
                            >
                                Manage customer information and booking history.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Total Customers -->

                <div
                    class="card rounded-xl px-4 py-3 flex items-center gap-3 min-w-[165px]"
                >

                    <div
                        class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"
                    >

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                            />

                            <circle
                                cx="9"
                                cy="7"
                                r="4"
                            />

                            <path
                                stroke-linecap="round"
                                d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                            />

                        </svg>

                    </div>


                    <div>

                        <p
                            class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                        >
                            Total Customers
                        </p>

                        <p
                            class="text-xl font-black text-[#17233C] leading-none mt-1"
                        >
                            <?= $totalCustomers ?>
                        </p>

                    </div>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- SUMMARY -->
            <!-- ===================================================== -->

            <div
                class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5"
            >


                <!-- Active -->

                <div class="card rounded-xl px-4 py-3">

                    <div
                        class="flex items-center justify-between"
                    >

                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                            >
                                Active Customers
                            </p>

                            <p
                                class="text-2xl font-black text-[#17233C] mt-1"
                            >
                                <?= $activeCustomers ?>
                            </p>

                        </div>


                        <div
                            class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                <!-- Customers with bookings -->

                <div class="card rounded-xl px-4 py-3">

                    <div
                        class="flex items-center justify-between"
                    >

                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                            >
                                With Bookings
                            </p>

                            <p
                                class="text-2xl font-black text-[#17233C] mt-1"
                            >
                                <?= $bookingCustomers ?>
                            </p>

                        </div>


                        <div
                            class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 6h16v12H4z"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M8 10h8M8 14h5"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                <!-- Inactive -->

                <div class="card rounded-xl px-4 py-3">

                    <div
                        class="flex items-center justify-between"
                    >

                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                            >
                                Inactive
                            </p>

                            <p
                                class="text-2xl font-black text-[#17233C] mt-1"
                            >
                                <?= $inactiveCustomers ?>
                            </p>

                        </div>


                        <div
                            class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="8"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M9 9l6 6M15 9l-6 6"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


            </div>



            <!-- ===================================================== -->
            <!-- SEARCH / FILTER -->
            <!-- ===================================================== -->

            <div
                class="card rounded-xl overflow-hidden mb-5"
            >


                <div
                    class="px-4 sm:px-5 py-3 border-b border-slate-100 flex items-center justify-between"
                >

                    <div>

                        <h2
                            class="text-base font-extrabold text-[#17233C]"
                        >
                            Search & Filters
                        </h2>

                        <p
                            class="text-xs text-slate-400 mt-0.5"
                        >
                            Find a customer quickly
                        </p>

                    </div>


                    <div
                        class="text-xs font-semibold text-slate-400"
                    >

                        <?= count($customers) ?> results

                    </div>

                </div>


                <form
                    method="GET"
                    action="customers.php"
                    class="p-4 sm:p-5"
                >

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3"
                    >


                        <!-- Search -->

                        <div class="lg:col-span-2">

                            <label
                                class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5"
                            >
                                Search
                            </label>

                            <div class="relative">

                                <svg
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >

                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="7"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="m20 20-4-4"
                                    />

                                </svg>

                                <input
                                    type="text"
                                    name="search"
                                    value="<?= htmlspecialchars($search) ?>"
                                    placeholder="Customer number, name, mobile or email..."
                                    class="input-field w-full pl-9 pr-3 py-2.5 rounded-lg text-sm text-slate-700 placeholder-slate-400"
                                >

                            </div>

                        </div>


                        <!-- City -->

                        <div>

                            <label
                                class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5"
                            >
                                City
                            </label>

                            <select
                                name="city"
                                class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700"
                            >

                                <option value="">
                                    All Cities
                                </option>

                                <option
                                    value="Pune"
                                    <?= $city === 'Pune' ? 'selected' : '' ?>
                                >
                                    Pune
                                </option>

                                <option
                                    value="Chandrapur"
                                    <?= $city === 'Chandrapur' ? 'selected' : '' ?>
                                >
                                    Chandrapur
                                </option>

                            </select>

                        </div>


                        <!-- Status -->

                        <div>

                            <label
                                class="block text-[10px] uppercase tracking-wider font-bold text-slate-500 mb-1.5"
                            >
                                Status
                            </label>

                            <select
                                name="status"
                                class="input-field w-full px-3 py-2.5 rounded-lg text-sm text-slate-700"
                            >

                                <option value="">
                                    All Statuses
                                </option>

                                <option
                                    value="active"
                                    <?= $status === 'active' ? 'selected' : '' ?>
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    <?= $status === 'inactive' ? 'selected' : '' ?>
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>


                    </div>


                    <!-- Buttons -->

                    <div
                        class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-100"
                    >

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#17233C] hover:bg-[#101a2e] text-white rounded-lg text-sm font-bold transition-colors shadow-sm"
                        >

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <circle
                                    cx="11"
                                    cy="11"
                                    r="7"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="m20 20-4-4"
                                />

                            </svg>

                            Apply Filters

                        </button>


                        <a
                            href="customers.php"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg text-sm font-semibold transition-colors"
                        >
                            Reset
                        </a>

                    </div>

                </form>

            </div>



            <!-- ===================================================== -->
            <!-- CUSTOMER RECORDS -->
            <!-- ===================================================== -->

            <div>


                <div
                    class="flex items-end justify-between mb-3"
                >

                    <div>

                        <div class="flex items-center gap-2">

                            <h2
                                class="text-xl font-black text-[#17233C]"
                            >
                                Customer Records
                            </h2>

                            <span
                                class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold"
                            >
                                <?= count($customers) ?>
                            </span>

                        </div>

                        <p
                            class="text-xs text-slate-400 mt-1"
                        >
                            Registered customers and their booking activity
                        </p>

                    </div>

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
                                class="bg-[#F8FAFC] border-b border-slate-200"
                            >

                                <tr>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Customer
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Contact
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        City
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Bookings
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Last Booking
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-4 py-3 text-right text-[10px] uppercase tracking-wider font-bold text-slate-500"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                class="divide-y divide-slate-100"
                            >


                            <?php if (empty($customers)): ?>


                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-6 py-12 text-center"
                                    >

                                        <div
                                            class="w-11 h-11 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3"
                                        >

                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                                />

                                                <circle
                                                    cx="9"
                                                    cy="7"
                                                    r="4"
                                                />

                                            </svg>

                                        </div>

                                        <p
                                            class="font-bold text-slate-700"
                                        >
                                            No customers found
                                        </p>

                                        <p
                                            class="text-xs text-slate-400 mt-1"
                                        >
                                            Try changing your search or filters.
                                        </p>

                                    </td>

                                </tr>


                            <?php else: ?>


                                <?php foreach ($customers as $customer): ?>


                                    <tr class="customer-row">


                                        <!-- Customer -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="font-extrabold text-[#17233C] text-sm"
                                            >

                                                <?= htmlspecialchars(
                                                    $customer['name']
                                                ) ?>

                                            </p>

                                            <p
                                                class="text-[10px] text-slate-400 mt-0.5"
                                            >

                                                <?= htmlspecialchars(
                                                    $customer['customer_number']
                                                ) ?>

                                            </p>

                                        </td>


                                        <!-- Contact -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <p
                                                class="text-sm font-semibold text-slate-700"
                                            >

                                                <?= htmlspecialchars(
                                                    $customer['mobile']
                                                ) ?>

                                            </p>

                                            <?php if (
                                                !empty($customer['email'])
                                            ): ?>

                                                <p
                                                    class="text-[10px] text-slate-400 mt-0.5"
                                                >

                                                    <?= htmlspecialchars(
                                                        $customer['email']
                                                    ) ?>

                                                </p>

                                            <?php endif; ?>

                                        </td>


                                        <!-- City -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <span
                                                class="text-sm font-semibold text-slate-700"
                                            >

                                                <?= htmlspecialchars(
                                                    $customer['city']
                                                ) ?>

                                            </span>

                                        </td>


                                        <!-- Bookings -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <span
                                                class="inline-flex items-center justify-center min-w-[30px] h-7 px-2 rounded-md bg-slate-100 text-slate-700 text-xs font-black"
                                            >

                                                <?= (int) $customer['total_bookings'] ?>

                                            </span>

                                        </td>


                                        <!-- Last Booking -->

                                        <td
                                            class="px-4 py-3 whitespace-nowrap"
                                        >

                                            <?php if (
                                                !empty($customer['last_booking'])
                                            ): ?>

                                                <p
                                                    class="text-xs font-semibold text-slate-700"
                                                >

                                                    <?= date(
                                                        'd M Y',
                                                        strtotime(
                                                            $customer['last_booking']
                                                        )
                                                    ) ?>

                                                </p>

                                                <p
                                                    class="text-[10px] text-slate-400 mt-0.5"
                                                >

                                                    <?= date(
                                                        'h:i A',
                                                        strtotime(
                                                            $customer['last_booking']
                                                        )
                                                    ) ?>

                                                </p>

                                            <?php else: ?>

                                                <span
                                                    class="text-xs text-slate-400"
                                                >
                                                    No bookings
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- Status -->

                                        <td
                                            class="px-4 py-3"
                                        >

                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase
                                                <?= $customer['status'] === 'active'
                                                    ? 'bg-blue-50 text-blue-700'
                                                    : 'bg-slate-100 text-slate-500'
                                                ?>"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-current"
                                                ></span>

                                                <?= ucfirst(
                                                    htmlspecialchars(
                                                        $customer['status']
                                                    )
                                                ) ?>

                                            </span>

                                        </td>


                                        <!-- Action -->

                                        <td
                                            class="px-4 py-3 text-right"
                                        >

                                            <a
                                                href="customer-details.php?id=<?= (int) $customer['id'] ?>"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#17233C] hover:bg-[#101a2e] text-white text-[11px] font-bold transition-colors"
                                            >

                                                View

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
                <!-- MOBILE CARDS -->
                <!-- ================================================= -->

                <div class="md:hidden space-y-3">


                <?php if (empty($customers)): ?>


                    <div
                        class="card rounded-xl p-8 text-center"
                    >

                        <p class="font-bold text-slate-700">
                            No customers found
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Try changing your search or filters.
                        </p>

                    </div>


                <?php else: ?>


                    <?php foreach ($customers as $customer): ?>


                        <article
                            class="card rounded-xl overflow-hidden"
                        >


                            <!-- Header -->

                            <div
                                class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between gap-3"
                            >

                                <div>

                                    <p
                                        class="font-black text-[#17233C] text-sm"
                                    >

                                        <?= htmlspecialchars(
                                            $customer['name']
                                        ) ?>

                                    </p>

                                    <p
                                        class="text-[10px] text-slate-400 mt-0.5"
                                    >

                                        <?= htmlspecialchars(
                                            $customer['customer_number']
                                        ) ?>

                                    </p>

                                </div>


                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[9px] font-bold uppercase
                                    <?= $customer['status'] === 'active'
                                        ? 'bg-blue-50 text-blue-700'
                                        : 'bg-slate-100 text-slate-500'
                                    ?>"
                                >

                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-current"
                                    ></span>

                                    <?= ucfirst(
                                        htmlspecialchars(
                                            $customer['status']
                                        )
                                    ) ?>

                                </span>

                            </div>


                            <!-- Body -->

                            <div class="p-4">


                                <div class="space-y-2">


                                    <div
                                        class="flex justify-between gap-4"
                                    >

                                        <span
                                            class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                                        >
                                            Mobile
                                        </span>

                                        <span
                                            class="text-xs font-semibold text-slate-700"
                                        >

                                            <?= htmlspecialchars(
                                                $customer['mobile']
                                            ) ?>

                                        </span>

                                    </div>


                                    <?php if (
                                        !empty($customer['email'])
                                    ): ?>

                                        <div
                                            class="flex justify-between gap-4"
                                        >

                                            <span
                                                class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                                            >
                                                Email
                                            </span>

                                            <span
                                                class="text-xs font-semibold text-slate-700 text-right break-all"
                                            >

                                                <?= htmlspecialchars(
                                                    $customer['email']
                                                ) ?>

                                            </span>

                                        </div>

                                    <?php endif; ?>


                                    <div
                                        class="flex justify-between gap-4"
                                    >

                                        <span
                                            class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                                        >
                                            City
                                        </span>

                                        <span
                                            class="text-xs font-semibold text-slate-700"
                                        >

                                            <?= htmlspecialchars(
                                                $customer['city']
                                            ) ?>

                                        </span>

                                    </div>


                                    <div
                                        class="flex justify-between gap-4"
                                    >

                                        <span
                                            class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                                        >
                                            Bookings
                                        </span>

                                        <span
                                            class="text-xs font-black text-[#17233C]"
                                        >

                                            <?= (int) $customer['total_bookings'] ?>

                                        </span>

                                    </div>


                                    <div
                                        class="flex justify-between gap-4"
                                    >

                                        <span
                                            class="text-[10px] uppercase tracking-wider font-bold text-slate-400"
                                        >
                                            Last Booking
                                        </span>

                                        <span
                                            class="text-xs font-semibold text-slate-700"
                                        >

                                            <?php if (
                                                !empty($customer['last_booking'])
                                            ): ?>

                                                <?= date(
                                                    'd M Y',
                                                    strtotime(
                                                        $customer['last_booking']
                                                    )
                                                ) ?>

                                            <?php else: ?>

                                                No bookings

                                            <?php endif; ?>

                                        </span>

                                    </div>


                                </div>


                                <a
                                    href="customer-details.php?id=<?= (int) $customer['id'] ?>"
                                    class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#17233C] hover:bg-[#101a2e] text-white rounded-lg text-xs font-bold transition-colors"
                                >

                                    View Customer

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
                                            d="M9 5l7 7-7 7"
                                        />

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