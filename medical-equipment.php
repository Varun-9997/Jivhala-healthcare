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


<title>Medical Equipment</title>


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
        flex items-center gap-3"
    >

        <span
            class="w-1.5 h-7
            bg-[#A6292F]
            rounded-full
            inline-block"
        ></span>

        Medical Equipment

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
                    Portea Services
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
                    Trained Attendant
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
                    Critical Care
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
                    Nursing
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
                    Doctor Consultation
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
                    href="#"
                    class="block py-2.5 px-2
                    text-slate-700
                    hover:text-teal-600
                    hover:bg-teal-50/60
                    rounded-lg
                    transition-colors"
                >
                    Lab Tests
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
                    Speciality Pharma
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
            Medical Equipment Information & FAQs
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
            Click any section (+) to expand content
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
                Getting medical equipment on rent or purchase at your doorstep has never been this convenient. During difficult phases of life, you or your loved one might need to rely on various medical equipment to get back to normal life. Jivhala Healthcare offers a wide range of medical equipment for rent or purchase making healthcare more accessible and affordable for you.
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

                    How Can We Help

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
                If you need any medical equipment for rent, browse our medical equipment catalogue and select the equipment required. Our team can assist you with rental, purchase, delivery and other requirements.
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

                    Medical Equipment Near Me

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
                With medical equipment available for home care, patients and families can manage many healthcare requirements more conveniently from home. Contact our team to check availability and delivery options in your area.
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

                    FAQs In Medical Equipment

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

                        To rent medical equipment, browse the available equipment, select the required equipment and submit a booking request. Our team will assist you with the rental process.

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

                        The available equipment is displayed in the categories above. Select any category to view the equipment currently available.

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

                        Is there a minimum period for equipment rental?

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

                        Rental periods may vary depending on the equipment. Please check the individual equipment details or contact our team for more information.

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

                        Do you provide delivery?

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

                        Contact our team to confirm delivery availability for your location and selected equipment.

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

                        What is the rental process for medical equipment?

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

                        Choose your equipment, review the rental details, submit a booking request and our team will contact you to proceed with the rental.

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

                        Are the equipment sanitized before delivery?

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

                        All equipment should be prepared and sanitized according to applicable healthcare and equipment-handling procedures before delivery.

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
                Why Rent Medical Equipment from Jivhala Healthcare?
            </h2>


            <p
                class="text-slate-600
                mt-2
                max-w-2xl
                mx-auto"
            >
                Affordable, reliable, and hassle-free medical equipment rental for your home care needs.
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
                    Cost-Effective
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    Renting is significantly more affordable than purchasing expensive medical equipment, especially for short-term needs.
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
                    Doorstep Delivery
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    We help make medical equipment access convenient by assisting with delivery and setup requirements.
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
                    Maintenance & Support
                </h3>


                <p
                    class="text-sm
                    text-slate-600
                    mt-2"
                >
                    Our team can assist with equipment-related support, maintenance and replacement requirements during the rental period.
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
                Browse our extensive range of medical equipment by category
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