<?php

include 'conn.php';


/*
|--------------------------------------------------------------------------
| Get Equipment ID
|--------------------------------------------------------------------------
*/

$equipmentId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($equipmentId <= 0) {

    header("Location: medical-equipment.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Equipment + Category
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        e.id,
        e.category_id,
        e.name,
        e.slug,
        e.image,
        e.short_description,
        e.description,
        e.technical_specifications,
        e.brands,
        e.purchase_price,
        e.rental_price,
        e.rental_period,

        c.name AS category_name,
        c.slug AS category_slug

    FROM equipment e

    INNER JOIN equipment_categories c
        ON c.id = e.category_id

    WHERE e.id = ?
      AND e.status = 1
      AND c.status = 1

    LIMIT 1
");

$stmt->execute([$equipmentId]);

$product = $stmt->fetch();


/*
|--------------------------------------------------------------------------
| Equipment Not Found
|--------------------------------------------------------------------------
*/

if (!$product) {

    header("Location: medical-equipment.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Prepare Technical Specifications
|--------------------------------------------------------------------------
|
| Your database stores technical specifications as TEXT.
|
| We support:
|
| 1. One specification per line
| 2. Bullet-separated specifications
|
*/

$specifications = [];

if (!empty($product['technical_specifications'])) {

    $specificationText = trim($product['technical_specifications']);

    $specifications = preg_split(
        '/\r\n|\r|\n/',
        $specificationText
    );

    $specifications = array_filter(
        array_map('trim', $specifications)
    );
}


/*
|--------------------------------------------------------------------------
| Prepare Brands
|--------------------------------------------------------------------------
*/

$brands = trim($product['brands'] ?? '');


/*
|--------------------------------------------------------------------------
| Price Formatting
|--------------------------------------------------------------------------
*/

$purchasePrice = null;
$rentalPrice = null;

if ($product['purchase_price'] !== null) {

    $purchasePrice = number_format(
        (float) $product['purchase_price'],
        2
    );
}

if ($product['rental_price'] !== null) {

    $rentalPrice = number_format(
        (float) $product['rental_price'],
        2
    );
}


include 'header.php';

?><div class="bg-[#f8f6ef] min-h-screen py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- BREADCRUMB -->
        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="medical-equipment.php" class="hover:text-teal-600 transition-colors">Home</a>
            <span>›</span>
            <a href="medical-equipment.php" class="hover:text-teal-600 transition-colors">Medical Equipment</a>
            <span>›</span>
            <a href="equipment-list.php?category=<?= urlencode($product['category_slug']) ?>"
               class="hover:text-teal-600 transition-colors">
                <?= htmlspecialchars($product['category_name']) ?>
            </a>
            <span>›</span>
            <span class="text-slate-700"><?= htmlspecialchars($product['name']) ?></span>
        </div>

        <!-- PRODUCT HEADER -->
        <section class="mb-7">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-50 border border-teal-100 text-[10px] font-bold uppercase tracking-wider text-teal-700">
                Medical Equipment Support
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3">
                <?= htmlspecialchars($product['name']) ?>
            </h1>
            <p class="text-sm text-slate-500 mt-2 max-w-3xl">
                Medical equipment solutions to support home-based and institutional healthcare requirements, with rental and purchase options subject to availability.
            </p>
        </section>

        <!-- PRODUCT + BOOKING -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <!-- PRODUCT IMAGE -->
                    <div class="h-[320px] sm:h-[430px] bg-slate-50 flex items-center justify-center p-6 sm:p-10">
                        <?php if (!empty($product['image'])): ?>
                        <img
                            src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="max-h-full max-w-full object-contain"
                            onerror="this.style.display='none'; document.getElementById('imageFallback').classList.remove('hidden');">
                        <?php endif; ?>
                        <div id="imageFallback"
                             class="<?= !empty($product['image']) ? 'hidden' : '' ?> text-center text-slate-400">
                            <div class="text-7xl mb-3">🩺</div>
                            <p class="text-sm">Equipment Image</p>
                        </div>
                    </div>

                    <!-- PRICING -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border-t border-slate-100">
                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Purchase Price</p>
                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">
                                <?php if ($purchasePrice !== null): ?>
                                ₹<?= htmlspecialchars($purchasePrice) ?>
                                <?php else: ?>
                                Contact Us
                                <?php endif; ?>
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1">Final purchase terms will be confirmed by our service team.</p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rental Price</p>
                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">
                                <?php if ($rentalPrice !== null): ?>
                                ₹<?= htmlspecialchars($rentalPrice) ?>
                                <?php if (!empty($product['rental_period'])): ?>
                                <span class="text-xs font-semibold text-slate-500">/ <?= htmlspecialchars($product['rental_period']) ?></span>
                                <?php endif; ?>
                                <?php else: ?>
                                Contact Us
                                <?php endif; ?>
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1">Rental terms and availability will be confirmed by our service team.</p>
                        </div>
                    </div>
                </div>

                <!-- TRUST / SERVICE STRIP -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4">
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-bold text-slate-900">Equipment Rental</p>
                        <p class="text-[11px] text-slate-500 mt-1">Support for home healthcare needs</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-bold text-slate-900">Equipment Sales</p>
                        <p class="text-[11px] text-slate-500 mt-1">Purchase options where available</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-bold text-slate-900">Home ICU Support</p>
                        <p class="text-[11px] text-slate-500 mt-1">Equipment for home & institutional needs</p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <p class="text-xs font-bold text-slate-900">Service Support</p>
                        <p class="text-[11px] text-slate-500 mt-1">Assistance with your requirement</p>
                    </div>
                </div>
            </div>

            <!-- BOOKING CARD -->
            <aside class="lg:col-span-4 lg:sticky lg:top-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-teal-600 text-white px-5 py-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-teal-100">Medical Equipment Support</p>
                        <h2 class="font-bold text-lg mt-1">Request Equipment</h2>
                        <p class="text-xs text-teal-50 mt-1">Choose rental or purchase and submit your details.</p>
                    </div>

                    <form id="bookingForm" class="p-5 space-y-4">
                        <input type="hidden" name="equipment_id" value="<?= (int) $product['id'] ?>">

                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Name</label>
                            <input id="name" name="name" type="text" required placeholder="Enter your name"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                        </div>

                        <div>
                            <label for="mobile" class="block text-xs font-semibold text-slate-700 mb-1.5">Mobile Number</label>
                            <input id="mobile" name="mobile" type="tel" inputmode="numeric" maxlength="10" required
                                   placeholder="Enter 10-digit mobile number"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                        </div>

                        <div>
                            <label for="city" class="block text-xs font-semibold text-slate-700 mb-1.5">City</label>
                            <select id="city" name="city" required
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm bg-white outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100">
                                <option value="">Select City</option>
                                <option value="Pune">Pune</option>
                                <option value="Chandrapur">Chandrapur</option>
                            </select>
                        </div>

                        <fieldset>
                            <legend class="block text-xs font-semibold text-slate-700 mb-2">Booking Type</legend>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="booking_type" value="rental" class="peer sr-only" checked>
                                    <span class="flex items-center justify-center min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">Rent</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="booking_type" value="purchase" class="peer sr-only">
                                    <span class="flex items-center justify-center min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">Purchase</span>
                                </label>
                            </div>
                        </fieldset>

                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex justify-between gap-4 text-xs">
                                <span class="text-slate-500">Selected equipment</span>
                                <span class="font-semibold text-slate-800 text-right"><?= htmlspecialchars($product['name']) ?></span>
                            </div>
                            <div class="flex justify-between gap-4 mt-2 text-sm">
                                <span class="font-semibold text-slate-700">Amount</span>
                                <span id="selectedAmount" class="font-extrabold text-teal-700">
                                    <?php if ($rentalPrice !== null): ?>
                                    ₹<?= htmlspecialchars($rentalPrice) ?>
                                    <?php else: ?>
                                    Contact Us
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" id="consent" required
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            <span class="text-[11px] leading-relaxed text-slate-500">
                                I agree to be contacted regarding this equipment booking and understand that final rental/purchase terms will be confirmed by the service team.
                            </span>
                        </label>

                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 min-h-11 px-5 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-bold transition-colors">
                            Book Now <span>→</span>
                        </button>

                        <p id="bookingMessage" class="hidden text-xs rounded-lg p-3"></p>
                    </form>
                </div>
            </aside>
        </section>

        <!-- DESCRIPTION / SPECIFICATIONS -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-7 mt-7">
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <div class="border-l-4 border-teal-600 pl-4 mb-7">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-teal-700">Equipment Information</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 mt-1">About This Equipment</h2>
                </div>

                <?php if (!empty($product['description'])): ?>
                <p class="text-sm leading-7 text-slate-600"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <?php elseif (!empty($product['short_description'])): ?>
                <p class="text-sm leading-7 text-slate-600"><?= nl2br(htmlspecialchars($product['short_description'])) ?></p>
                <?php else: ?>
                <p class="text-sm leading-7 text-slate-500">Equipment details will be provided by our service team.</p>
                <?php endif; ?>

                <?php if (!empty($specifications)): ?>
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">Technical Specifications</h3>
                    <ul class="mt-4 space-y-2 text-sm text-slate-600 list-disc pl-5">
                        <?php foreach ($specifications as $specification): ?>
                        <li><?= htmlspecialchars($specification) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ($brands !== ''): ?>
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">Brands & Models Available</h3>
                    <p class="mt-4 text-sm text-slate-600 leading-7"><?= nl2br(htmlspecialchars($brands)) ?></p>
                </div>
                <?php endif; ?>

                <!-- SERVICE CONTEXT -->
                <div class="mt-10 rounded-2xl bg-teal-50/70 border border-teal-100 p-5">
                    <h3 class="text-lg font-bold text-slate-900">Medical Equipment & Institutional Care Support</h3>
                    <p class="text-sm leading-7 text-slate-600 mt-2">
                        Jivhala Healthcare aims to provide medical equipment solutions that support patient convenience and home-based or institutional healthcare requirements.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <div class="bg-white rounded-xl border border-teal-100 p-3">
                            <p class="text-xs font-bold text-slate-800">Medical Equipment Rental</p>
                        </div>
                        <div class="bg-white rounded-xl border border-teal-100 p-3">
                            <p class="text-xs font-bold text-slate-800">Medical Equipment Sales</p>
                        </div>
                        <div class="bg-white rounded-xl border border-teal-100 p-3">
                            <p class="text-xs font-bold text-slate-800">Hospital / Home ICU Support</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="mt-10">
                    <h3 class="text-xl font-bold text-slate-900 border-l-4 border-teal-600 pl-3">Frequently Asked Questions</h3>
                    <div class="mt-5 space-y-3">

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                What is this medical equipment used for?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                Please refer to the equipment description and technical specifications above. Our service team can also help you understand the equipment information relevant to your requirement.
                            </div>
                        </details>

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                What specifications does this equipment have?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                The technical specifications for the selected equipment are listed above when available.
                            </div>
                        </details>

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                Is the equipment available for rent and purchase?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                <?php if ($product['rental_price'] !== null && $product['purchase_price'] !== null): ?>
                                This equipment is currently listed for both rental and purchase. Final availability and terms will be confirmed by our service team.
                                <?php elseif ($product['rental_price'] !== null): ?>
                                This equipment is currently listed for rental. Final availability and rental terms will be confirmed by our service team.
                                <?php elseif ($product['purchase_price'] !== null): ?>
                                This equipment is currently listed for purchase. Final availability and purchase terms will be confirmed by our service team.
                                <?php else: ?>
                                Please contact our service team for current rental or purchase availability.
                                <?php endif; ?>
                            </div>
                        </details>

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                Is home delivery available?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                Delivery availability depends on location and equipment. The service team will confirm delivery details after receiving the booking request.
                            </div>
                        </details>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <aside class="lg:col-span-4 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 text-base border-b-2 border-teal-600 pb-3">
                        Jivhala Healthcare Services
                    </h3>
                    <nav class="divide-y divide-slate-100 text-sm font-medium">
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Home Nursing</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Patient Care</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Elder Care</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Mother & Baby Care</a>
                        <a href="medical-equipment.php" class="block py-2.5 px-2 text-teal-700 font-bold bg-teal-50/80 rounded-lg">Medical Equipment</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Doctor Visit</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Physiotherapy</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Wound Care</a>
                        <a href="#" class="block py-2.5 px-2 text-slate-700 hover:text-teal-600 hover:bg-teal-50/60 rounded-lg transition-colors">Nursing & Medical Support</a>
                    </nav>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 text-base border-b-2 border-teal-600 pb-3">Need Help?</h3>
                    <p class="text-sm leading-6 text-slate-600 mt-4">
                        Contact Jivhala Healthcare to discuss your medical equipment requirement, rental or purchase enquiry.
                    </p>
                    <a href="tel:+919860390012" class="mt-4 flex items-center justify-center w-full rounded-xl bg-teal-50 text-teal-700 font-bold text-sm py-3 hover:bg-teal-100 transition-colors">
                        +91 9860390012
                    </a>
                    <p class="text-xs text-slate-500 text-center mt-3">Healthcare support for home & institutional requirements</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 text-base border-b-2 border-teal-600 pb-3">Explore This Category</h3>
                    <a href="equipment-list.php?category=<?= urlencode($product['category_slug']) ?>"
                       class="block py-3 text-sm font-semibold text-teal-700 hover:underline border-b border-slate-100">
                        More <?= htmlspecialchars($product['category_name']) ?>
                    </a>
                    <a href="medical-equipment.php"
                       class="block py-3 text-sm font-semibold text-teal-700 hover:underline">
                        All Medical Equipment
                    </a>
                </div>

                <div class="bg-teal-900 rounded-2xl p-5 text-white">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-teal-200">Jivhala Healthcare</p>
                    <h3 class="text-lg font-bold mt-1">Integrated Healthcare Support</h3>
                    <p class="text-xs leading-5 text-teal-50 mt-2">
                        Compassionate home healthcare, trained workforce and coordinated support for patients, families and institutions.
                    </p>
                </div>
            </aside>
        </section>

        <!-- CONTACT / SUPPORT -->
        <section class="mt-10 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-teal-700">Medical Equipment</p>
                    <h3 class="text-lg font-bold text-slate-900 mt-1">Rental & Sales Support</h3>
                    <p class="text-sm leading-6 text-slate-600 mt-2">Solutions for home-based and institutional healthcare requirements.</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-teal-700">Contact</p>
                    <p class="text-sm font-bold text-slate-900 mt-1">+91 9860390012</p>
                    <p class="text-xs text-slate-500 mt-1">jivhalahealthcare@gmail.com</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-teal-700">Location</p>
                    <p class="text-sm font-bold text-slate-900 mt-1">Chandrapur, Maharashtra</p>
                    <p class="text-xs text-slate-500 mt-1">Flat No. S-3, Shobha Tower, Datala, Chandrapur – 442406</p>
                </div>
            </div>
        </section>

    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<!-- ========================================= -->
<!-- BOOKING JAVASCRIPT -->
<!-- ========================================= -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('bookingForm');
        const amount = document.getElementById('selectedAmount');
        const message = document.getElementById('bookingMessage');

        if (!form || !amount || !message) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Prices From Database
        |--------------------------------------------------------------------------
        */

        const rentalPrice = <?= json_encode(
                                $rentalPrice !== null
                                    ? '₹' . $rentalPrice
                                    : 'Contact Us'
                            ) ?>;

        const purchasePrice = <?= json_encode(
                                    $purchasePrice !== null
                                        ? '₹' . $purchasePrice
                                        : 'Contact Us'
                                ) ?>;


        /*
        |--------------------------------------------------------------------------
        | Submit Button
        |--------------------------------------------------------------------------
        */

        const submitButton = form.querySelector(
            'button[type="submit"]'
        );


        /*
        |--------------------------------------------------------------------------
        | Change Amount
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('input[name="booking_type"]')
            .forEach(function(radio) {

                radio.addEventListener('change', function() {

                    if (this.value === 'purchase') {

                        amount.textContent = purchasePrice;

                    } else {

                        amount.textContent = rentalPrice;

                    }

                });

            });


        /*
        |--------------------------------------------------------------------------
        | Form Submit
        |--------------------------------------------------------------------------
        */

        form.addEventListener('submit', function(event) {

            event.preventDefault();


            /*
            |--------------------------------------------------------------------------
            | Mobile Validation
            |--------------------------------------------------------------------------
            */

            const mobileInput = document.getElementById('mobile');

            const mobile = mobileInput.value.trim();

            if (!/^[0-9]{10}$/.test(mobile)) {

                showMessage(
                    'Please enter a valid 10-digit mobile number.',
                    'error'
                );

                mobileInput.focus();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Browser Validation
            |--------------------------------------------------------------------------
            */

            if (!form.checkValidity()) {

                form.reportValidity();

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Disable Button
            |--------------------------------------------------------------------------
            */

            submitButton.disabled = true;

            submitButton.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <span class="h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                Processing...
            </span>
        `;


            /*
            |--------------------------------------------------------------------------
            | Hide Previous Message
            |--------------------------------------------------------------------------
            */

            message.classList.add('hidden');


            /*
            |--------------------------------------------------------------------------
            | Form Data
            |--------------------------------------------------------------------------
            */

            const formData = new FormData(form);


            /*
            |--------------------------------------------------------------------------
            | Send Booking To PHP
            |--------------------------------------------------------------------------
            */

            fetch('process_booking.php', {

                    method: 'POST',

                    body: formData

                })

                .then(function(response) {

                    return response.text().then(function(text) {

                        console.log('Server response:', text);

                        let data;

                        try {

                            data = JSON.parse(text);

                        } catch (error) {

                            throw new Error(
                                'Invalid server response: ' + text
                            );

                        }

                        return data;

                    });

                })

                .then(function(data) {

                    /*
                    |--------------------------------------------------------------------------
                    | Successful Booking
                    |--------------------------------------------------------------------------
                    */

                    if (data.success) {

                        const options = {
                            key: data.razorpay_key_id,
                            amount: data.razorpay_amount,
                            currency: 'INR',
                            name: 'Jivhala Healthcare',
                            description: data.equipment_name,
                            order_id: data.razorpay_order_id,

                            prefill: {
                                name: data.customer_name,
                                contact: data.mobile,
                                email: data.email || ''
                            },

                            theme: {
                                color: '#2563EB'
                            },

                            handler: function(response) {

                                console.log('Razorpay payment response:', response);

                                const paymentData = new FormData();

                                paymentData.append(
                                    'razorpay_payment_id',
                                    response.razorpay_payment_id
                                );

                                paymentData.append(
                                    'razorpay_order_id',
                                    response.razorpay_order_id
                                );

                                paymentData.append(
                                    'razorpay_signature',
                                    response.razorpay_signature
                                );

                                fetch('verify_payment.php', {
                                        method: 'POST',
                                        body: paymentData
                                    })
                                    .then(response => response.json())
                                    .then(data => {

                                        console.log('Payment verification response:', data);

                                        if (data.success) {

                                            alert(
                                                'Payment successful!\n\n' +
                                                'Booking Number: ' + data.booking_number
                                            );

                                            /*
                                             * For now, reload the page so we can verify
                                             * the database status.
                                             */
                                            window.location.reload();

                                        } else {

                                            alert(
                                                'Payment verification failed.\n\n' +
                                                (data.message || 'Please contact us.')
                                            );
                                        }

                                    })
                                    .catch(error => {

                                        console.error(
                                            'Payment verification error:',
                                            error
                                        );

                                        alert(
                                            'Payment was completed, but we could not verify it right now. ' +
                                            'Please contact us with your payment details.'
                                        );
                                    });
                            },

                            modal: {
                                ondismiss: function() {
                                    console.log('Razorpay Checkout closed.');
                                    enableButton();
                                }
                            }
                        };

                        const razorpay = new Razorpay(options);

                        razorpay.open();
                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | PHP Validation / Database Error
                        |--------------------------------------------------------------------------
                        */

                        showMessage(
                            data.message || 'Unable to submit booking.',
                            'error'
                        );

                        enableButton();

                    }

                })

                .catch(function(error) {

                    console.error(
                        'Booking Error:',
                        error
                    );

                    showMessage(
                        error.message ||
                        'Unable to submit your booking right now. Please try again.',
                        'error'
                    );

                    enableButton();

                });

        });


        /*
        |--------------------------------------------------------------------------
        | Show Message
        |--------------------------------------------------------------------------
        */

        function showMessage(text, type) {

            message.classList.remove(
                'hidden',
                'text-teal-700',
                'bg-teal-50',
                'border-teal-100',
                'text-red-700',
                'bg-red-50',
                'border-red-100',
                'border'
            );


            message.classList.add('border');


            if (type === 'success') {

                message.classList.add(
                    'text-teal-700',
                    'bg-teal-50',
                    'border-teal-100'
                );

            } else {

                message.classList.add(
                    'text-red-700',
                    'bg-red-50',
                    'border-red-100'
                );

            }


            message.innerHTML = text;


            message.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });

        }


        /*
        |--------------------------------------------------------------------------
        | Enable Button
        |--------------------------------------------------------------------------
        */

        function enableButton() {

            submitButton.disabled = false;

            submitButton.innerHTML = `
            Book Now
            <span>→</span>
        `;

        }


        /*
        |--------------------------------------------------------------------------
        | Escape HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            const div = document.createElement('div');

            div.textContent = value ?? '';

            return div.innerHTML;

        }

    });
</script>


<?php include 'footer.php'; ?>