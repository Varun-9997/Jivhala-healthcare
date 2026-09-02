<?php
include 'header.php';

/*
|--------------------------------------------------------------------------
| Static equipment data for UI development
|--------------------------------------------------------------------------
| Later, this array can be replaced with database/API data.
*/

$category = $_GET['category'] ?? 'oxygen-concentrators';

$categories = [
    'oxygen-concentrators' => [
        'title' => 'Oxygen Concentrators',
        'description' => 'Browse our range of oxygen concentrators available for rent or purchase.',
        'products' => [
            [
                'id' => 1,
                'name' => 'Oxygen Concentrator 5 LPM',
                'slug' => 'oxygen-concentrator-5-lpm',
                'image' => 'assets/images/equipment/oxygen-concentrator-5-lpm.jpg',
                'rental_price' => '₹4,500',
                'rental_period' => '30 days',
                'purchase_price' => '₹45,000',
                'short_description' => 'Compact 5 LPM oxygen concentrator suitable for home oxygen therapy.'
            ],
            [
                'id' => 2,
                'name' => 'Oxygen Concentrator 8 LPM',
                'slug' => 'oxygen-concentrator-8-lpm',
                'image' => 'assets/images/equipment/oxygen-concentrator-8-lpm.jpg',
                'rental_price' => '₹6,000',
                'rental_period' => '30 days',
                'purchase_price' => '₹55,000',
                'short_description' => 'Reliable 8 LPM oxygen concentrator designed for continuous home use.'
            ],
            [
                'id' => 3,
                'name' => 'Oxygen Concentrator 9/10 LPM',
                'slug' => 'oxygen-concentrator-9-10-lpm',
                'image' => 'assets/images/equipment/oxygen-concentrator-9-10-lpm.jpg',
                'rental_price' => '₹7,300',
                'rental_period' => '30 days',
                'purchase_price' => '₹59,000 - ₹64,000',
                'short_description' => 'High-flow oxygen concentrator suitable for patients requiring higher oxygen flow.'
            ],
            [
                'id' => 4,
                'name' => 'Portable Oxygen Concentrator',
                'slug' => 'portable-oxygen-concentrator',
                'image' => 'assets/images/equipment/portable-oxygen-concentrator.jpg',
                'rental_price' => '₹8,000',
                'rental_period' => '30 days',
                'purchase_price' => '₹75,000',
                'short_description' => 'Portable oxygen solution designed for mobility and convenient home use.'
            ],
        ]
    ],
];

$currentCategory = $categories[$category] ?? $categories['oxygen-concentrators'];
?>

<div class="bg-[#f8f6ef] min-h-screen py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="medical-equipment.php" class="hover:text-teal-600">Home</a>
            <span>›</span>
            <a href="medical-equipment.php" class="hover:text-teal-600">Medical Equipment</a>
            <span>›</span>
            <span class="text-slate-700"><?= htmlspecialchars($currentCategory['title']) ?></span>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <span class="w-1.5 h-8 bg-[#A6292F] rounded-full"></span>
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900">
                        <?= htmlspecialchars($currentCategory['title']) ?>
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 mt-2">
                        <?= htmlspecialchars($currentCategory['description']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

            <!-- Product Listing -->
            <main class="lg:col-span-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <?php foreach ($currentCategory['products'] as $product): ?>
                        <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-teal-400 transition-all duration-300 overflow-hidden group">

                            <a href="equipment-details.php?id=<?= (int)$product['id'] ?>&category=<?= urlencode($category) ?>"
                               class="block">

                                <div class="aspect-[4/3] bg-slate-50 flex items-center justify-center p-6 overflow-hidden">
                                    <img
                                        src="<?= htmlspecialchars($product['image']) ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                    >

                                    <div class="hidden text-center text-slate-400">
                                        <div class="text-5xl mb-2">🩺</div>
                                        <p class="text-xs">Equipment Image</p>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <h2 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h2>

                                    <p class="text-xs sm:text-sm text-slate-500 mt-2 line-clamp-2">
                                        <?= htmlspecialchars($product['short_description']) ?>
                                    </p>

                                    <div class="grid grid-cols-2 gap-3 mt-5">
                                        <div class="rounded-xl bg-teal-50 border border-teal-100 p-3">
                                            <p class="text-[10px] uppercase tracking-wide text-slate-500 font-semibold">
                                                Rent
                                            </p>
                                            <p class="text-base font-extrabold text-teal-700 mt-1">
                                                <?= htmlspecialchars($product['rental_price']) ?>
                                            </p>
                                            <p class="text-[10px] text-slate-500">
                                                / <?= htmlspecialchars($product['rental_period']) ?>
                                            </p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                                            <p class="text-[10px] uppercase tracking-wide text-slate-500 font-semibold">
                                                Purchase
                                            </p>
                                            <p class="text-base font-extrabold text-slate-800 mt-1">
                                                <?= htmlspecialchars($product['purchase_price']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <span class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-semibold transition-colors">
                                        View Details
                                        <span>→</span>
                                    </span>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>

                </div>
            </main>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm lg:sticky lg:top-6">

                <div class="border-b-2 border-teal-600 pb-3 mb-4">
                    <h3 class="font-bold text-slate-900 text-lg">Portea Services</h3>
                </div>

                <nav class="divide-y divide-slate-100 text-sm font-medium">
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Elder Care</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Trained Attendant</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Physiotherapy</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Critical Care</a>
                    <a href="medical-equipment.php" class="block py-2.5 px-2 text-teal-700 font-bold bg-teal-50 rounded-lg">Medical Equipment</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Nursing</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Doctor Consultation</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Mother & Baby Care</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Lab Tests</a>
                    <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Speciality Pharma</a>
                </nav>

                <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <h4 class="font-bold text-slate-900 text-sm">Need help choosing?</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Contact our team for help selecting the right equipment for your requirement.
                    </p>
                    <a href="tel:18001212323" class="mt-3 inline-flex text-xs font-bold text-teal-700 hover:underline">
                        Call 1800-121-2323
                    </a>
                </div>

            </aside>
        </div>

        <!-- Bottom note -->
        <section class="mt-10 bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="font-bold text-slate-900 text-lg">Medical Equipment Rental & Purchase</h2>
            <p class="text-sm text-slate-600 mt-2 leading-relaxed max-w-4xl">
                Browse the available equipment, select a model to view complete specifications,
                rental and purchase pricing, and submit a booking request.
            </p>
        </section>

    </div>
</div>

<?php include 'footer.php' ?>
