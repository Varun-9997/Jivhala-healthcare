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

        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="medical-equipment.php" class="hover:text-teal-600 transition-colors">
                Home
            </a>
            <span>›</span>
            <a href="medical-equipment.php" class="hover:text-teal-600 transition-colors">
                Medical Equipment
            </a>
            <span>›</span>
            <span class="text-slate-700 font-medium">
                <?= htmlspecialchars($category['name']) ?>
            </span>
        </div>

        <!-- CATEGORY HEADER -->
        <div class="mb-8">
            <div class="flex items-start gap-3">
                <span class="w-1.5 h-9 bg-[#A6292F] rounded-full mt-1"></span>

                <div>
                    <p class="text-[11px] sm:text-xs font-bold uppercase tracking-widest text-teal-700 mb-1">
                        MEDICAL EQUIPMENT SUPPORT
                    </p>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900">
                        <?= htmlspecialchars($category['name']) ?>
                    </h1>

                    <?php if (!empty($category['description'])): ?>
                        <p class="text-sm sm:text-base text-slate-600 mt-2 max-w-3xl leading-relaxed">
                            <?= htmlspecialchars($category['description']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT + SIDEBAR -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

            <!-- EQUIPMENT LIST -->
            <main class="lg:col-span-3">

                <?php if (empty($equipmentList)): ?>

                    <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center shadow-sm">

                        <div class="w-16 h-16 mx-auto rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-4xl mb-4">
                            🩺
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            Equipment Currently Unavailable
                        </h2>

                        <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">
                            There is currently no equipment listed in this category.
                            Please explore other medical equipment categories or contact Jivhala Healthcare for assistance.
                        </p>

                        <a
                            href="medical-equipment.php"
                            class="mt-5 inline-flex items-center justify-center px-5 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-semibold transition-colors"
                        >
                            Browse Medical Equipment
                        </a>

                    </div>

                <?php else: ?>

                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div>
                            <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">
                                Available Equipment
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Explore the available options for rental or purchase.
                            </p>
                        </div>
                    </div>

                    <!-- PRODUCT GRID -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <?php foreach ($equipmentList as $equipment): ?>

                            <article
                                class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-teal-400 transition-all duration-300 overflow-hidden group"
                            >

                                <!-- PRODUCT IMAGE -->
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

                                    <!-- PRODUCT INFORMATION -->
                                    <div class="p-5">

                                        <div class="flex items-start justify-between gap-3">
                                            <h2 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">
                                                <?= htmlspecialchars($equipment['name']) ?>
                                            </h2>

                                            <span class="shrink-0 text-[10px] font-bold uppercase tracking-wide text-teal-700 bg-teal-50 border border-teal-100 px-2 py-1 rounded-full">
                                                Equipment
                                            </span>
                                        </div>

                                        <?php if (!empty($equipment['short_description'])): ?>

                                            <p class="text-xs sm:text-sm text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                                <?= htmlspecialchars($equipment['short_description']) ?>
                                            </p>

                                        <?php endif; ?>

                                        <!-- PRICES -->
                                        <div class="grid grid-cols-2 gap-3 mt-5">

                                            <!-- RENT -->
                                            <div class="rounded-xl bg-teal-50 border border-teal-100 p-3">
                                                <p class="text-[10px] uppercase tracking-wide text-slate-500 font-semibold">
                                                    Rental
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
                                            View Equipment Details
                                            <span>→</span>
                                        </span>

                                    </div>

                                </a>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </main>

            <!-- SIDEBAR -->
            <aside
                class="lg:col-span-1 bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm lg:sticky lg:top-6"
            >

                <div class="border-b-2 border-teal-600 pb-3 mb-4">
                    <h3 class="font-bold text-slate-900 text-lg">
                        Jivhala Healthcare Services
                    </h3>
                </div>

                <nav class="divide-y divide-slate-100 text-sm font-medium">

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Home Nursing
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Patient Care
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Elder Care
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Mother &amp; Baby Care
                    </a>

                    <a
                        href="medical-equipment.php"
                        class="block py-2.5 px-2 text-teal-700 font-bold bg-teal-50/80 rounded-lg"
                    >
                        Medical Equipment
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Doctor Visit
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Physiotherapy
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Wound Care
                    </a>

                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">
                        Nursing &amp; Medical Support
                    </a>

                </nav>

                <!-- HELP BOX -->
                <div class="mt-6 p-4 rounded-xl bg-teal-50/70 border border-teal-100">

                    <div class="w-10 h-10 rounded-xl bg-white border border-teal-100 flex items-center justify-center text-xl mb-3">
                        🩺
                    </div>

                    <h4 class="font-bold text-slate-900 text-sm">
                        Need help choosing equipment?
                    </h4>

                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Contact Jivhala Healthcare to discuss your medical equipment requirement,
                        including rental and purchase options.
                    </p>

                    <a
                        href="tel:+919860390012"
                        class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:underline"
                    >
                        📞 +91 98603 90012
                    </a>

                </div>

            </aside>

        </div>

        <!-- BOTTOM INFORMATION -->
        <section class="mt-10 bg-white rounded-2xl border border-slate-200 p-6 sm:p-7">

            <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                <div class="w-12 h-12 shrink-0 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center text-2xl">
                    🏥
                </div>

                <div>
                    <h2 class="font-bold text-slate-900 text-lg">
                        <?= htmlspecialchars($category['name']) ?> — Rental &amp; Purchase
                    </h2>

                    <p class="text-sm text-slate-600 mt-2 leading-relaxed max-w-4xl">
                        Browse the available <?= htmlspecialchars($category['name']) ?>,
                        select an equipment item to view its details, and check the available
                        rental or purchase option. For assistance with your requirement,
                        contact Jivhala Healthcare directly.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-teal-50 border border-teal-100 text-xs font-semibold text-teal-700">
                            Medical Equipment Rental
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700">
                            Medical Equipment Sales
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700">
                            Home &amp; Institutional Support
                        </span>
                    </div>
                </div>

            </div>

        </section>

    </div>

</div>


<?php include 'footer.php'; ?>