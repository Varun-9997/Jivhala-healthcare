<?php

$isAdmin = true;

?>

<aside
    id="sidebar"
    class="bg-white text-slate-700 border-r border-slate-200 w-60 transition-all duration-300 shadow-sm
    fixed md:relative z-40
    min-h-screen flex flex-col justify-between
    -translate-x-full md:translate-x-0
    overflow-y-auto">

    <div class="w-full">

        <!-- Sidebar Branding -->
        <div class="p-4 pl-8 border-b border-slate-200 flex items-center bg-slate-50/50 sidebar-logo overflow-hidden h-20 shrink-0">

            <div class="sidebar-text flex flex-col justify-center truncate transition-opacity duration-200 hidden md:flex">

                <span class="text-base font-black text-slate-900 tracking-wide font-sans uppercase truncate">
                    Jivhala Healthcare
                </span>

                <span class="text-[10px] font-extrabold text-teal-600 uppercase tracking-widest mt-0.5 truncate">
                    ADMIN WORKSPACE
                </span>

            </div>

        </div>


        <!-- Navigation -->
        <nav class="mt-6 space-y-3">


            <!-- Dashboard -->

            <a
                href="home.php"
                class="nav-link menu-item relative flex items-center justify-center md:justify-start gap-3 h-12 border border-l-4 border-l-transparent border-slate-200 text-slate-600 hover:text-indigo-950 hover:bg-slate-50 hover:border-slate-300 transition-all duration-150 rounded-lg mx-2 group">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-400 group-hover:text-indigo-950 transition shrink-0 md:ml-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>

                <span class="sidebar-text font-semibold text-sm truncate hidden md:block">
                    Dashboard
                </span>

                <span class="tooltip hidden group-hover:block absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow z-50 whitespace-nowrap">
                    Dashboard
                </span>

            </a>


            <!-- Equipment Category -->

            <a
                href="add-equipment.php"
                class="nav-link menu-item relative flex items-center justify-center md:justify-start gap-3 h-12 border border-l-4 border-l-transparent border-slate-200 text-slate-600 hover:text-indigo-950 hover:bg-slate-50 hover:border-slate-300 transition-all duration-150 rounded-lg mx-2 group">
                <!-- existing equipment icon -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-400 group-hover:text-teal-600 transition shrink-0 md:ml-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 3h6a2 2 0 012 2v1h2a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h2V5a2 2 0 012-2z" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6M12 9v6" />

                </svg>

                <span class="sidebar-text font-semibold text-sm truncate hidden md:block">
                    Equipment Category
                </span>

                <span class="tooltip hidden group-hover:block absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow z-50 whitespace-nowrap">
                    Equipment Category
                </span>
            </a>


            <!-- Equipment Details -->

            <a
                href="equipment-details.php"
                class="nav-link menu-item relative flex items-center justify-center md:justify-start gap-3 h-12 border border-l-4 border-l-transparent border-slate-200 text-slate-600 hover:text-indigo-950 hover:bg-slate-50 hover:border-slate-300 transition-all duration-150 rounded-lg mx-2 group">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-400 group-hover:text-teal-600 transition shrink-0 md:ml-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />
                </svg>

                <span class="sidebar-text font-semibold text-sm truncate hidden md:block">
                    Equipment Details
                </span>

                <span class="tooltip hidden group-hover:block absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow z-50 whitespace-nowrap">
                    Equipment Details
                </span>
            </a>


            <!-- Bookings -->

            <a
                href="bookings.php"
                class="nav-link menu-item relative flex items-center justify-center md:justify-start gap-3 h-12 border border-l-4 border-l-transparent border-slate-200 text-slate-600 hover:text-indigo-950 hover:bg-slate-50 hover:border-slate-300 transition-all duration-150 rounded-lg mx-2 group">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-400 group-hover:text-indigo-950 transition shrink-0 md:ml-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 2v4M16 2v4M3 10h18" />

                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 14h2M14 14h2M8 18h2" />

                </svg>

                <span class="sidebar-text font-semibold text-sm truncate hidden md:block">
                    Bookings
                </span>

                <span class="tooltip hidden group-hover:block absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow z-50 whitespace-nowrap">
                    Bookings
                </span>

            </a>


            <!-- Customers -->

            <a
                href="customers.php"
                class="nav-link menu-item relative flex items-center justify-center md:justify-start gap-3 h-12 border border-l-4 border-l-transparent border-slate-200 text-slate-600 hover:text-indigo-950 hover:bg-slate-50 hover:border-slate-300 transition-all duration-150 rounded-lg mx-2 group">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-slate-400 group-hover:text-indigo-950 transition shrink-0 md:ml-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />

                    <circle
                        cx="9"
                        cy="7"
                        r="4" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />

                </svg>

                <span class="sidebar-text font-semibold text-sm truncate hidden md:block">
                    Customers
                </span>

                <span class="tooltip hidden group-hover:block absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-xs rounded shadow z-50 whitespace-nowrap">
                    Customers
                </span>

            </a>


        </nav>

    </div>

</aside>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        /*
        |--------------------------------------------------------------------------
        | Highlight Active Menu
        |--------------------------------------------------------------------------
        */

        const currentPath =
            window.location.pathname.split("/").pop();

        document.querySelectorAll(".nav-link").forEach(function(link) {

            const hrefAttr =
                link.getAttribute("href");

            if (
                currentPath === hrefAttr ||
                (currentPath === "" && hrefAttr === "index.php")
            ) {

                link.classList.remove(
                    "border-l-transparent",
                    "text-slate-600"
                );

                link.classList.add(
                    "border-l-teal-600",
                    "bg-teal-50/80",
                    "text-teal-800",
                    "font-bold"
                );


                const icon =
                    link.querySelector("svg");

                if (icon) {

                    icon.classList.remove(
                        "text-slate-400"
                    );

                    icon.classList.add(
                        "text-teal-700"
                    );

                }

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Sidebar Toggle
    |--------------------------------------------------------------------------
    */

    function sidebarToggle() {

        const sidebar =
            document.getElementById("sidebar");

        if (!sidebar) {
            return;
        }

        sidebar.classList.toggle("-translate-x-full");

    }
</script>