<?php

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

include 'conn.php';


/*
|--------------------------------------------------------------------------
| Fetch Active Equipment Categories
|--------------------------------------------------------------------------
*/

$categoryStmt = $pdo->prepare("
    SELECT
        id,
        name,
        slug,
        description,
        image
    FROM equipment_categories
    WHERE status = 1
    ORDER BY id ASC
");

$categoryStmt->execute();

$categories = $categoryStmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Include Header
|--------------------------------------------------------------------------
| Keep this AFTER all PHP processing.
|--------------------------------------------------------------------------
*/

include 'header.php';

?>


<title>Medical Equipment | Jivhala Healthcare</title>


<div class="max-w-7xl mx-auto space-y-12">


<!-- =========================================================
     SECTION 1: MEDICAL EQUIPMENT & SIDEBAR
========================================================= -->

<section class="space-y-6">


    <!-- PAGE TITLE -->

    <h2
        class="text-2xl sm:text-3xl
        font-extrabold
        text-slate-900
        tracking-tight
        flex items-center gap-3 mt-4"
    >

        <span
            class="w-1.5 h-7
            bg-[#A6292F]
            rounded-full
            inline-block"
        ></span>

        Medical Equipment & Support

    </h2>


    <div
        class="grid
        grid-cols-1
        lg:grid-cols-4
        gap-8
        items-start"
    >


        <!-- =====================================================
             PRODUCT GRID
        ====================================================== -->

        <div
            class="lg:col-span-3
            grid
            grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            gap-5"
        >


            <?php if (empty($categories)): ?>


                <!-- NO CATEGORIES -->

                <div
                    class="sm:col-span-2
                    md:col-span-3
                    bg-white
                    rounded-2xl
                    border border-slate-200
                    p-10
                    text-center"
                >

                    <div class="text-5xl mb-4">
                        🩺
                    </div>


                    <h3
                        class="text-xl
                        font-bold
                        text-slate-900"
                    >
                        No Equipment Categories Available
                    </h3>


                    <p
                        class="text-sm
                        text-slate-500
                        mt-2"
                    >
                        Equipment categories will appear here once they are added.
                    </p>

                </div>


            <?php else: ?>


                <!-- =================================================
                     DYNAMIC CATEGORY CARDS
                ================================================== -->

                <?php foreach ($categories as $category): ?>


                    <div
                        class="bg-white
                        rounded-2xl
                        p-4
                        border border-slate-200/80
                        shadow-sm
                        hover:shadow-md
                        hover:border-teal-500
                        transition-all
                        duration-300
                        flex flex-col
                        justify-between
                        group"
                    >


                        <!-- CATEGORY IMAGE -->

                        <a
                            href="equipment-list.php?category=<?= urlencode($category['slug']); ?>"
                            class="block"
                        >

                            <div
                                class="aspect-[4/3]
                                w-full
                                bg-slate-100/70
                                rounded-xl
                                mb-4
                                flex items-center
                                justify-center
                                p-4
                                overflow-hidden"
                            >


                                <?php if (!empty($category['image'])): ?>


                                    <img
                                        src="<?= htmlspecialchars($category['image']); ?>"
                                        alt="<?= htmlspecialchars($category['name']); ?>"
                                        class="w-full h-full
                                        object-contain
                                        group-hover:scale-105
                                        transition-transform
                                        duration-300"
                                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                    >


                                <?php endif; ?>


                                <!-- IMAGE FALLBACK -->

                                <div
                                    class="<?= !empty($category['image']) ? 'hidden' : ''; ?>
                                    text-center
                                    text-slate-400"
                                >

                                    <div class="text-5xl mb-2">
                                        🩺
                                    </div>

                                    <p class="text-xs">
                                        Equipment Image
                                    </p>

                                </div>


                            </div>

                        </a>


                        <!-- CATEGORY INFORMATION -->

                        <div class="space-y-4">


                            <h3
                                class="font-bold
                                text-slate-900
                                text-base
                                border-l-4
                                border-teal-600
                                pl-2.5
                                leading-snug"
                            >

                                <?= htmlspecialchars($category['name']); ?>

                            </h3>


                            <?php if (!empty($category['description'])): ?>

                                <p
                                    class="text-xs
                                    text-slate-500
                                    line-clamp-2"
                                >

                                    <?= htmlspecialchars(
                                        $category['description']
                                    ); ?>

                                </p>

                            <?php endif; ?>


                            <a
                                href="equipment-list.php?category=<?= urlencode($category['slug']); ?>"
                                class="w-full
                                inline-flex
                                items-center
                                justify-center
                                gap-1.5
                                px-4 py-2.5
                                bg-[#A6292F]
                                hover:bg-[#e04319]
                                text-white
                                rounded-xl
                                text-xs
                                font-semibold
                                tracking-wide
                                transition-colors"
                            >

                                View Details

                                <span>→</span>

                            </a>


                        </div>


                    </div>


                <?php endforeach; ?>


            <?php endif; ?>


        </div>



        <!-- =====================================================
             SIDEBAR: PORTEA SERVICES
        ====================================================== -->

        <aside
            class="lg:col-span-1
            bg-white
            rounded-2xl
            p-5
            border border-slate-200/80
            shadow-sm
            sticky
            top-6"
        >


            <div
                class="border-b-2
                border-teal-600
                pb-3
                mb-4"
            >

                <h3
                    class="font-bold
                    text-slate-900
                    text-lg"
                >
                    Jivhala Healthcare Services
                </h3>

            </div>


<nav
    class="divide-y
    divide-slate-100
    text-sm
    font-medium"
>

    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Home Nursing
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Patient Care
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Elder Care
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Mother & Baby Care
    </a>


    <a
        href="medical-equipment.php"
        class="block py-2.5 px-2
        text-teal-700
        font-bold
        bg-teal-50/80
        rounded-lg"
    >
        Medical Equipment
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Doctor Visit
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Physiotherapy
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Wound Care
    </a>


    <a
        href="#"
        class="block py-2.5 px-2
        text-slate-700
        hover:text-teal-600
        hover:bg-teal-50/60
        rounded-lg
        transition-colors"
    >
        Injection & IV Care
    </a>

</nav>


        </aside>


    </div>

</section>



<!-- =========================================================
     SECTION 2: INFORMATION & FAQS
========================================================= -->

<section
    class="bg-white
    rounded-3xl
    p-6 sm:p-10
    border border-slate-200/80
    shadow-sm
    space-y-6"
>


    <div
        class="flex flex-col
        sm:flex-row
        sm:items-center
        justify-between
        border-b
        border-slate-100
        pb-4
        gap-2"
    >

        <h2
            class="text-xl sm:text-2xl
            font-bold
            text-slate-900"
        >
            Medical Equipment & Support Information
        </h2>


        <span
            class="text-xs
            font-semibold
            text-teal-600
            bg-teal-50
            px-3 py-1
            rounded-full
            border border-teal-200"
        >
            Click any section (+) to learn more
        </span>

    </div>


    <div class="space-y-3.5">


        <!-- Accordion 1 -->

        <details
            class="group
            bg-slate-50/80
            rounded-2xl
            border border-slate-200/80
            overflow-hidden
            transition-all
            duration-300
            open:border-teal-500
            open:bg-white
            open:ring-1
            open:ring-teal-500"
        >

            <summary
                class="flex
                items-center
                justify-between
                p-5
                cursor-pointer
                select-none
                font-bold
                text-slate-900
                text-base
                sm:text-lg"
            >

                <span
                    class="flex
                    items-center
                    gap-3"
                >

                    <span
                        class="w-1.5 h-5
                        bg-[#A6292F]
                        rounded-full"
                    ></span>

                    Medical Equipment For Home & Institutional Care

                </span>


                <span
                    class="w-8 h-8
                    rounded-full
                    bg-white
                    text-slate-600
                    border border-slate-200
                    flex items-center
                    justify-center
                    font-bold
                    text-xl
                    transition-all
                    duration-300
                    group-open:rotate-45
                    group-open:bg-[#A6292F]
                    group-open:text-white
                    group-open:border-teal-600
                    shrink-0
                    ml-3
                    shadow-sm"
                >
                    +
                </span>

            </summary>


            <div
                class="p-5 pt-2
                text-slate-600
                text-sm
                leading-relaxed
                border-t
                border-slate-100"
            >
                Jivhala Healthcare provides medical equipment solutions to support patient convenience and home-based and institutional healthcare requirements. Our offerings include medical equipment rental, medical equipment sales, and support for home ICU and patient care equipment.
            </div>

        </details>



        <!-- Accordion 2 -->

        <details
            class="group
            bg-slate-50/80
            rounded-2xl
            border border-slate-200/80
            overflow-hidden
            transition-all
            duration-300
            open:border-teal-500
            open:bg-white
            open:ring-1
            open:ring-teal-500"
        >

            <summary
                class="flex
                items-center
                justify-between
                p-5
                cursor-pointer
                select-none
                font-bold
                text-slate-900
                text-base
                sm:text-lg"
            >

                <span
                    class="flex
                    items-center
                    gap-3"
                >

                    <span
                        class="w-1.5 h-5
                        bg-[#A6292F]
                        rounded-full"
                    ></span>

                    Medical Equipment Support

                </span>


                <span
                    class="w-8 h-8
                    rounded-full
                    bg-white
                    text-slate-600
                    border border-slate-200
                    flex items-center
                    justify-center
                    font-bold
                    text-xl
                    transition-all
                    duration-300
                    group-open:rotate-45
                    group-open:bg-[#A6292F]
                    group-open:text-white
                    group-open:border-teal-600
                    shrink-0
                    ml-3
                    shadow-sm"
                >
                    +
                </span>

            </summary>


            <div
                class="p-5 pt-2
                text-slate-600
                text-sm
                leading-relaxed
                border-t
                border-slate-100"
            >
                If you require medical equipment for home or institutional care, browse the available categories and select the equipment you need. Jivhala Healthcare provides rental and sales support, along with assistance for home ICU and patient care equipment.
            </div>

        </details>



        <!-- Accordion 3 -->

        <details
            class="group
            bg-slate-50/80
            rounded-2xl
            border border-slate-200/80
            overflow-hidden
            transition-all
            duration-300
            open:border-teal-500
            open:bg-white
            open:ring-1
            open:ring-teal-500"
        >

            <summary
                class="flex
                items-center
                justify-between
                p-5
                cursor-pointer
                select-none
                font-bold
                text-slate-900
                text-base
                sm:text-lg"
            >

                <span
                    class="flex
                    items-center
                    gap-3"
                >

                    <span
                        class="w-1.5 h-5
                        bg-[#A6292F]
                        rounded-full"
                    ></span>

                    Medical Equipment For Home Care

                </span>


                <span
                    class="w-8 h-8
                    rounded-full
                    bg-white
                    text-slate-600
                    border border-slate-200
                    flex items-center
                    justify-center
                    font-bold
                    text-xl
                    transition-all
                    duration-300
                    group-open:rotate-45
                    group-open:bg-[#A6292F]
                    group-open:text-white
                    group-open:border-teal-600
                    shrink-0
                    ml-3
                    shadow-sm"
                >
                    +
                </span>

            </summary>


            <div
                class="p-5 pt-2
                text-slate-600
                text-sm
                leading-relaxed
                border-t
                border-slate-100"
            >
                Medical equipment can support patients and families with home-based healthcare requirements. Contact Jivhala Healthcare to discuss your equipment requirement and check the available options for your needs.
            </div>

        </details>



        <!-- Accordion 4 -->

        <details
            class="group
            bg-slate-50/80
            rounded-2xl
            border border-slate-200/80
            overflow-hidden
            transition-all
            duration-300
            open:border-teal-500
            open:bg-white
            open:ring-1
            open:ring-teal-500"
        >

            <summary
                class="flex
                items-center
                justify-between
                p-5
                cursor-pointer
                select-none
                font-bold
                text-slate-900
                text-base
                sm:text-lg"
            >

                <span
                    class="flex
                    items-center
                    gap-3"
                >

                    <span
                        class="w-1.5 h-5
                        bg-[#A6292F]
                        rounded-full"
                    ></span>

                    Frequently Asked Questions

                </span>


                <span
                    class="w-8 h-8
                    rounded-full
                    bg-white
                    text-slate-600
                    border border-slate-200
                    flex items-center
                    justify-center
                    font-bold
                    text-xl
                    transition-all
                    duration-300
                    group-open:rotate-45
                    group-open:bg-[#A6292F]
                    group-open:text-white
                    group-open:border-teal-600
                    shrink-0
                    ml-3
                    shadow-sm"
                >
                    +
                </span>

            </summary>


            <div
                class="p-5 pt-3
                text-slate-600
                text-sm
                leading-relaxed
                border-t
                border-slate-100
                space-y-4"
            >


                <!-- Q1 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        How can I rent medical equipment?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        Browse the available equipment categories, select the equipment required and submit your booking request. Our team can assist you with the rental process and related requirements.

                    </p>

                </div>



                <!-- Q2 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        What equipment is available?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        The available equipment is displayed in the categories above. Select a category to view the equipment currently listed under it.

                    </p>

                </div>



                <!-- Q3 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        Can I purchase medical equipment instead of renting it?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        Yes. Jivhala Healthcare provides both medical equipment rental and medical equipment sales. Please contact our team to discuss the equipment you require.

                    </p>

                </div>



                <!-- Q4 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        What type of medical equipment support do you provide?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        Our medical equipment offering includes rental and sales support, along with home ICU support equipment and patient care devices for home and institutional healthcare requirements.

                    </p>

                </div>



                <!-- Q5 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        Can medical equipment be used for home ICU support?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        Jivhala Healthcare provides home ICU support equipment as part of its medical equipment solutions. Contact our team to discuss your specific requirement and available options.

                    </p>

                </div>



                <!-- Q6 -->

                <div
                    class="p-4
                    rounded-xl
                    bg-white
                    border border-slate-200/60
                    shadow-sm
                    space-y-1.5"
                >

                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-start
                        gap-2"
                    >

                        <span class="text-teal-600">
                            Q:
                        </span>

                        Do you provide medical equipment for institutional requirements?

                    </h4>


                    <p
                        class="text-slate-600
                        text-xs
                        sm:text-sm
                        pl-5"
                    >

                        <strong class="text-slate-800">
                            A –
                        </strong>

                        Yes. Jivhala Healthcare provides medical equipment solutions for both home-based and institutional healthcare requirements. Contact our team to discuss your institutional requirement.

                    </p>

                </div>


            </div>

        </details>


    </div>

</section>



<!-- =========================================================
     SECTION 3: WHY RENT MEDICAL EQUIPMENT
========================================================= -->

<section
    class="py-12
    bg-teal-50/70
    rounded-3xl
    border border-teal-100"
>


    <div
        class="max-w-7xl
        mx-auto
        px-4
        sm:px-6
        lg:px-8"
    >


        <div class="text-center mb-10">


            <span
                class="bg-[#A6292F]
                text-white
                text-xs
                px-4 py-1
                rounded-full
                uppercase
                font-bold
                tracking-wider"
            >
                Benefits
            </span>


            <h2
                class="text-2xl
                sm:text-3xl
                font-extrabold
                text-slate-900
                mt-3
                font-serif"
            >
                Medical Equipment Solutions For Your Healthcare Needs
            </h2>


            <p
                class="text-slate-600
                mt-2
                max-w-2xl
                mx-auto"
            >
                Medical equipment rental and sales support for home-based and institutional healthcare requirements.
            </p>


        </div>



        <div
            class="grid
            grid-cols-1
            md:grid-cols-3
            gap-6"
        >


            <!-- BENEFIT 1 -->

            <div
                class="bg-white
                p-6
                rounded-2xl
                border border-teal-100
                shadow-sm
                hover:shadow-md
                transition-all"
            >

                <div
                    class="w-14 h-14
                    rounded-xl
                    bg-teal-50
                    text-teal-600
                    flex items-center
                    justify-center
                    text-3xl
                    mb-4"
                >
                    💰
                </div>


                <h3
                    class="text-lg
                    font-bold
                    text-slate-900"
                >
                    Rental & Sales Support
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    Jivhala Healthcare provides medical equipment through rental and sales options to support different patient care and healthcare requirements.
                </p>

            </div>



            <!-- BENEFIT 2 -->

            <div
                class="bg-white
                p-6
                rounded-2xl
                border border-teal-100
                shadow-sm
                hover:shadow-md
                transition-all"
            >

                <div
                    class="w-14 h-14
                    rounded-xl
                    bg-teal-50
                    text-teal-600
                    flex items-center
                    justify-center
                    text-3xl
                    mb-4"
                >
                    🚚
                </div>


                <h3
                    class="text-lg
                    font-bold
                    text-slate-900"
                >
                    Home ICU Support
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    Our medical equipment solutions include support for home ICU requirements and patient care equipment.
                </p>

            </div>



            <!-- BENEFIT 3 -->

            <div
                class="bg-white
                p-6
                rounded-2xl
                border border-teal-100
                shadow-sm
                hover:shadow-md
                transition-all"
            >

                <div
                    class="w-14 h-14
                    rounded-xl
                    bg-teal-50
                    text-teal-600
                    flex items-center
                    justify-center
                    text-3xl
                    mb-4"
                >
                    🔄
                </div>


                <h3
                    class="text-lg
                    font-bold
                    text-slate-900"
                >
                    Home & Institutional Support
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    Our medical equipment services are designed to support both home-based and institutional healthcare requirements.
                </p>

            </div>


        </div>

    </div>

</section>



<!-- =========================================================
     SECTION 4: EQUIPMENT CATEGORIES
========================================================= -->

<section
    class="py-12
    bg-white"
>


    <div
        class="max-w-7xl
        mx-auto
        px-4
        sm:px-6
        lg:px-8"
    >


        <div class="text-center mb-10">


            <span
                class="bg-slate-800
                text-white
                text-xs
                px-4 py-1
                rounded-full
                uppercase
                font-bold
                tracking-wider"
            >
                Categories
            </span>


            <h2
                class="text-2xl
                sm:text-3xl
                font-extrabold
                text-slate-900
                mt-3
                font-serif"
            >
                Equipment Categories
            </h2>


            <p class="text-slate-600 mt-2">
                Explore the available medical equipment categories and select the equipment required.
            </p>


        </div>



        <!-- =====================================================
             DYNAMIC CATEGORY LINKS
        ====================================================== -->

        <div
            class="grid
            grid-cols-1
            sm:grid-cols-2
            lg:grid-cols-4
            gap-4"
        >


            <?php foreach ($categories as $category): ?>


                <a
                    href="equipment-list.php?category=<?= urlencode($category['slug']); ?>"
                    class="bg-slate-50
                    p-5
                    rounded-xl
                    border border-slate-200
                    hover:border-teal-400
                    hover:shadow-md
                    transition-all
                    block"
                >


                    <h4
                        class="font-bold
                        text-slate-900
                        text-sm
                        flex items-center
                        gap-2"
                    >

                        <span
                            class="text-teal-600
                            text-lg"
                        >
                            🩺
                        </span>

                        <?= htmlspecialchars($category['name']); ?>

                    </h4>


                    <?php if (!empty($category['description'])): ?>

                        <p
                            class="text-xs
                            text-slate-500
                            mt-1
                            line-clamp-2"
                        >

                            <?= htmlspecialchars(
                                $category['description']
                            ); ?>

                        </p>

                    <?php else: ?>

                        <p
                            class="text-xs
                            text-slate-500
                            mt-1"
                        >
                            View available equipment
                        </p>

                    <?php endif; ?>


                </a>


            <?php endforeach; ?>


        </div>

    </div>

</section>


</div>


<?php include 'footer.php'; ?>