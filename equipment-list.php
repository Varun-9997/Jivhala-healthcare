<?php

include 'conn.php';


/*
|--------------------------------------------------------------------------
| Get Category From URL
|--------------------------------------------------------------------------
|
| Example:
| equipment-list.php?category=wheelchairs
|
*/

$categorySlug = $_GET['category'] ?? '';

$categorySlug = trim($categorySlug);


/*
|--------------------------------------------------------------------------
| Validate Category
|--------------------------------------------------------------------------
*/

if ($categorySlug === '') {

    header("Location: medical-equipment.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Category
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
    WHERE slug = ?
      AND status = 1
    LIMIT 1
");

$categoryStmt->execute([$categorySlug]);

$category = $categoryStmt->fetch();


/*
|--------------------------------------------------------------------------
| Category Not Found
|--------------------------------------------------------------------------
*/

if (!$category) {

    header("Location: medical-equipment.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Equipment For This Category
|--------------------------------------------------------------------------
*/

$equipmentStmt = $pdo->prepare("
    SELECT
        id,
        category_id,
        name,
        slug,
        image,
        short_description,
        description,
        purchase_price,
        rental_price,
        rental_period
    FROM equipment
    WHERE category_id = ?
      AND status = 1
    ORDER BY id ASC
");

$equipmentStmt->execute([$category['id']]);

$equipmentList = $equipmentStmt->fetchAll();

include 'header.php';

?>

<div class="bg-[#f8f6ef] min-h-screen py-10 sm:py-14">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


        <!-- ========================================= -->
        <!-- BREADCRUMB -->
        <!-- ========================================= -->

        <div class="flex items-center gap-2 text-xs text-slate-500 mb-6">

            <a
                href="medical-equipment.php"
                class="hover:text-teal-600"
            >
                Home
            </a>

            <span>›</span>

            <a
                href="medical-equipment.php"
                class="hover:text-teal-600"
            >
                Medical Equipment
            </a>

            <span>›</span>

            <span class="text-slate-700">
                <?= htmlspecialchars($category['name']) ?>
            </span>

        </div>


        <!-- ========================================= -->
        <!-- CATEGORY HEADER -->
        <!-- ========================================= -->

        <div class="mb-8">

            <div class="flex items-center gap-3">

                <span class="w-1.5 h-8 bg-[#A6292F] rounded-full"></span>

                <div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900">

                        <?= htmlspecialchars($category['name']) ?>

                    </h1>


                    <?php if (!empty($category['description'])): ?>

                        <p class="text-sm sm:text-base text-slate-600 mt-2">

                            <?= htmlspecialchars($category['description']) ?>

                        </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <!-- ========================================= -->
        <!-- MAIN CONTENT + SIDEBAR -->
        <!-- ========================================= -->

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">


            <!-- ========================================= -->
            <!-- EQUIPMENT LIST -->
            <!-- ========================================= -->

            <main class="lg:col-span-3">


                <?php if (empty($equipmentList)): ?>

                    <!-- NO EQUIPMENT -->

                    <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">

                        <div class="text-5xl mb-4">
                            🩺
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            No Equipment Available
                        </h2>

                        <p class="text-sm text-slate-500 mt-2">
                            There is currently no equipment available in this category.
                        </p>

                        <a
                            href="medical-equipment.php"
                            class="mt-5 inline-flex items-center justify-center px-5 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-semibold"
                        >
                            Browse All Equipment
                        </a>

                    </div>


                <?php else: ?>


                    <!-- PRODUCT GRID -->

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                        <?php foreach ($equipmentList as $equipment): ?>


                            <article
                                class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-teal-400 transition-all duration-300 overflow-hidden group"
                            >


                                <!-- ================================= -->
                                <!-- PRODUCT IMAGE -->
                                <!-- ================================= -->

                                <a
                                    href="equipment-details.php?id=<?= (int)$equipment['id'] ?>"
                                    class="block"
                                >

                                    <div class="aspect-[4/3] bg-slate-50 flex items-center justify-center p-6 overflow-hidden">


                                        <?php if (!empty($equipment['image'])): ?>

                                            <img
                                                src="<?= htmlspecialchars($equipment['image']) ?>"
                                                alt="<?= htmlspecialchars($equipment['name']) ?>"
                                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                                                onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                            >

                                        <?php endif; ?>


                                        <!-- IMAGE FALLBACK -->

                                        <div
                                            class="<?= !empty($equipment['image']) ? 'hidden' : '' ?> text-center text-slate-400"
                                        >

                                            <div class="text-5xl mb-2">
                                                🩺
                                            </div>

                                            <p class="text-xs">
                                                Equipment Image
                                            </p>

                                        </div>


                                    </div>


                                    <!-- ================================= -->
                                    <!-- PRODUCT INFORMATION -->
                                    <!-- ================================= -->

                                    <div class="p-5">


                                        <h2 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">

                                            <?= htmlspecialchars($equipment['name']) ?>

                                        </h2>


                                        <?php if (!empty($equipment['short_description'])): ?>

                                            <p class="text-xs sm:text-sm text-slate-500 mt-2 line-clamp-2">

                                                <?= htmlspecialchars($equipment['short_description']) ?>

                                            </p>

                                        <?php endif; ?>


                                        <!-- PRICES -->

                                        <div class="grid grid-cols-2 gap-3 mt-5">


                                            <!-- RENT -->

                                            <div class="rounded-xl bg-teal-50 border border-teal-100 p-3">

                                                <p class="text-[10px] uppercase tracking-wide text-slate-500 font-semibold">
                                                    Rent
                                                </p>


                                                <p class="text-base font-extrabold text-teal-700 mt-1">

                                                    <?php if ($equipment['rental_price'] !== null): ?>

                                                        ₹<?= number_format((float)$equipment['rental_price'], 2) ?>

                                                    <?php else: ?>

                                                        Contact Us

                                                    <?php endif; ?>

                                                </p>


                                                <?php if (!empty($equipment['rental_period'])): ?>

                                                    <p class="text-[10px] text-slate-500">

                                                        / <?= htmlspecialchars($equipment['rental_period']) ?>

                                                    </p>

                                                <?php endif; ?>

                                            </div>


                                            <!-- PURCHASE -->

                                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">

                                                <p class="text-[10px] uppercase tracking-wide text-slate-500 font-semibold">
                                                    Purchase
                                                </p>


                                                <p class="text-base font-extrabold text-slate-800 mt-1">

                                                    <?php if ($equipment['purchase_price'] !== null): ?>

                                                        ₹<?= number_format((float)$equipment['purchase_price'], 2) ?>

                                                    <?php else: ?>

                                                        Contact Us

                                                    <?php endif; ?>

                                                </p>

                                            </div>


                                        </div>


                                        <!-- VIEW DETAILS BUTTON -->

                                        <span
                                            class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-semibold transition-colors"
                                        >

                                            View Details

                                            <span>→</span>

                                        </span>


                                    </div>

                                </a>

                            </article>


                        <?php endforeach; ?>


                    </div>


                <?php endif; ?>


            </main>



            <!-- ========================================= -->
            <!-- SIDEBAR -->
            <!-- ========================================= -->

            <aside
                class="lg:col-span-1 bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm lg:sticky lg:top-6"
            >


                <div class="border-b-2 border-teal-600 pb-3 mb-4">

                    <h3 class="font-bold text-slate-900 text-lg">
                        Portea Services
                    </h3>

                </div>


                <nav class="divide-y divide-slate-100 text-sm font-medium">


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Elder Care
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Trained Attendant
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Physiotherapy
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Critical Care
                    </a>


                    <a
                        href="medical-equipment.php"
                        class="block py-2.5 px-2 text-teal-700 font-bold bg-teal-50 rounded-lg"
                    >
                        Medical Equipment
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Nursing
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Doctor Consultation
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Mother & Baby Care
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Lab Tests
                    </a>


                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        Speciality Pharma
                    </a>


                </nav>


                <!-- HELP BOX -->

                <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200">

                    <h4 class="font-bold text-slate-900 text-sm">
                        Need help choosing?
                    </h4>

                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Contact our team for help selecting the right equipment for your requirement.
                    </p>

                    <a
                        href="tel:18001212323"
                        class="mt-3 inline-flex text-xs font-bold text-teal-700 hover:underline"
                    >
                        Call 1800-121-2323
                    </a>

                </div>


            </aside>


        </div>


        <!-- ========================================= -->
        <!-- BOTTOM INFORMATION -->
        <!-- ========================================= -->

        <section class="mt-10 bg-white rounded-2xl border border-slate-200 p-6">

            <h2 class="font-bold text-slate-900 text-lg">

                <?= htmlspecialchars($category['name']) ?>
                Rental & Purchase

            </h2>


            <p class="text-sm text-slate-600 mt-2 leading-relaxed max-w-4xl">

                Browse the available
                <?= htmlspecialchars($category['name']) ?>,
                select a model to view complete specifications,
                rental and purchase pricing, and submit a booking request.

            </p>

        </section>


    </div>

</div>


<?php include 'footer.php'; ?>