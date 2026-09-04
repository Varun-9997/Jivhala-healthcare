<?php

/*
|--------------------------------------------------------------------------
| Admin Session
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_name('JIVHALA_ADMIN_SESSION');
    session_start();
}


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


/*
|--------------------------------------------------------------------------
| Update Activity
|--------------------------------------------------------------------------
*/

$_SESSION['last_activity'] = time();


$adminName = $_SESSION['admin_name'] ?? 'Administrator';
$adminEmail = $_SESSION['admin_email'] ?? '';
$adminRole = $_SESSION['admin_role'] ?? 'admin';

?>

<header class="bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm sticky top-0 z-50">

    <div class="flex items-center justify-between px-3 md:px-6 min-h-[5rem] py-2 relative gap-2">


        <!-- =========================================================
             Left Section
        ========================================================== -->

        <div class="flex items-center gap-2 md:gap-3 z-10 shrink-0">

            <button
                type="button"
                onclick="sidebarToggle()"
                class="p-2 md:p-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-600 hover:text-slate-900 transition focus:outline-none focus:ring-2 focus:ring-teal-600"
                aria-label="Toggle Sidebar"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

            </button>

        </div>


        <!-- =========================================================
             Center Branding
        ========================================================== -->

        <div class="flex-1 flex items-center justify-center gap-2 md:gap-3 px-2 text-center pointer-events-none min-w-0">

            <!-- Logo Placeholder -->
            <!-- Jivhala Healthcare Logo -->

<div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-xl overflow-hidden border border-slate-200 shrink-0 hidden sm:flex items-center justify-center bg-white">

    <img
        src="../img/JHCLOGO.jpeg"
        alt="Jivhala Healthcare"
        class="w-full h-full object-contain"
    >

</div>


            <!-- Brand Name -->

            <div class="min-w-0">

                <h1 class="text-base sm:text-lg md:text-xl font-black text-slate-900 tracking-wide leading-tight">

                    Jivhala Healthcare

                </h1>

                <p class="hidden sm:block text-[10px] md:text-xs text-slate-500 font-semibold tracking-wider uppercase mt-0.5">

                    Administration Panel

                </p>

            </div>

        </div>


        <!-- =========================================================
             Right Section
        ========================================================== -->

        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 z-10 shrink-0">


            <!-- Admin Profile -->

            <div class="relative profile-area inline-block">

                <button
                    type="button"
                    onclick="profileToggle(event)"
                    class="flex items-center gap-2 p-1 md:px-3 md:py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-medium text-sm transition focus:outline-none focus:ring-2 focus:ring-teal-600"
                >

                    <!-- Avatar -->

                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-xs md:text-sm">

                        <?= strtoupper(substr($adminName, 0, 1)); ?>

                    </div>


                    <!-- Name -->

                    <span class="hidden md:block font-bold max-w-[140px] truncate">

                        <?= htmlspecialchars($adminName); ?>

                    </span>


                    <!-- Arrow -->

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-slate-400 hidden md:block"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>

                </button>


                <!-- =================================================
                     Profile Dropdown
                ================================================== -->

                <div
                    id="ProfileDropDown"
                    class="hidden absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden z-50"
                >

                    <!-- Admin Information -->

                    <div class="px-4 py-4 bg-slate-50 border-b border-slate-100">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">

                                <?= strtoupper(substr($adminName, 0, 1)); ?>

                            </div>


                            <div class="min-w-0">

                                <p class="font-bold text-slate-800 truncate">

                                    <?= htmlspecialchars($adminName); ?>

                                </p>

                                <p class="text-xs text-slate-500 truncate mt-0.5">

                                    <?= htmlspecialchars($adminEmail); ?>

                                </p>

                                <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded">

                                    <?= htmlspecialchars($adminRole); ?>

                                </span>

                            </div>

                        </div>

                    </div>


                    <!-- Profile -->

                    <a
                        href="profile.php"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 font-semibold transition border-b border-slate-100"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-slate-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                            />
                        </svg>

                        <span>
                            My Profile
                        </span>

                    </a>


                    <!-- Logout -->

                    <a
                        href="logout.php"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-semibold transition"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-red-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"
                            />
                        </svg>

                        <span>
                            Logout
                        </span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</header>


<script>

/*
|--------------------------------------------------------------------------
| Profile Dropdown
|--------------------------------------------------------------------------
*/

function profileToggle(event) {

    event.stopPropagation();

    const profileDropdown =
        document.getElementById("ProfileDropDown");

    if (!profileDropdown) {
        return;
    }

    profileDropdown.classList.toggle("hidden");
}


/*
|--------------------------------------------------------------------------
| Close Dropdown When Clicking Outside
|--------------------------------------------------------------------------
*/

window.addEventListener("click", function(event) {

    const profileDropdown =
        document.getElementById("ProfileDropDown");

    if (
        profileDropdown &&
        !profileDropdown.classList.contains("hidden") &&
        !event.target.closest(".profile-area")
    ) {

        profileDropdown.classList.add("hidden");

    }

});

</script>