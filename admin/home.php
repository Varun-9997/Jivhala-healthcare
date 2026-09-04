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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard | Jivhala Healthcare</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col">

    <?php include "header.php"; ?>

    <div class="flex flex-1 relative">

        <?php include "sidebar.php"; ?>


        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 overflow-x-hidden">

            <div class="max-w-7xl mx-auto">

                <!-- Welcome Section -->
                <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-6 md:p-8 text-white shadow-md border border-slate-800 relative overflow-hidden">

                    <!-- Decorative Background -->
                    <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-teal-500/10 rounded-full blur-2xl"></div>

                    <div class="relative z-10">

                        <p class="text-sm text-slate-300 font-medium mb-2">
                            Welcome back,
                        </p>

                        <h1 class="text-2xl md:text-3xl font-black tracking-wide">
                            <?= htmlspecialchars($adminName); ?>
                        </h1>

                        <p class="mt-3 text-sm text-slate-300 max-w-xl leading-relaxed">
                            Welcome to the Jivhala Healthcare administration panel.
                            Manage equipment, bookings and other system information
                            from here.
                        </p>

                    </div>

                </div>


                <!-- Empty Dashboard Area -->
                <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm min-h-[400px] flex items-center justify-center">

                    <div class="text-center px-6">

                        <div class="w-16 h-16 mx-auto rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mb-4">

                            <svg
                                class="w-8 h-8"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1"
                                />
                            </svg>

                        </div>

                        <h2 class="text-lg font-bold text-slate-800">
                            Dashboard
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Dashboard information and statistics will be added here.
                        </p>

                    </div>

                </div>

            </div>

        </main>

    </div>


    <?php include "footer.php"; ?>

</body>

</html>