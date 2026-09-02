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

?>

<div class="bg-[#f8f6ef] min-h-screen py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


        <!-- ========================================= -->
        <!-- BREADCRUMB -->
        <!-- ========================================= -->

        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-6">

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

            <a
                href="equipment-list.php?category=<?= urlencode($product['category_slug']) ?>"
                class="hover:text-teal-600"
            >
                <?= htmlspecialchars($product['category_name']) ?>
            </a>

            <span>›</span>

            <span class="text-slate-700">
                <?= htmlspecialchars($product['name']) ?>
            </span>

        </div>



        <!-- ========================================= -->
        <!-- PRODUCT + BOOKING -->
        <!-- ========================================= -->

        <section class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">


            <!-- ========================================= -->
            <!-- PRODUCT -->
            <!-- ========================================= -->

            <div class="lg:col-span-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-6">

                    <?= htmlspecialchars($product['name']) ?>

                </h1>


                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">


                    <!-- PRODUCT IMAGE -->

                    <div class="h-[320px] sm:h-[430px] bg-white flex items-center justify-center p-6 sm:p-10">


                        <?php if (!empty($product['image'])): ?>

                            <img
                                src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="max-h-full max-w-full object-contain"
                                onerror="this.style.display='none'; document.getElementById('imageFallback').classList.remove('hidden');"
                            >

                        <?php endif; ?>


                        <!-- IMAGE FALLBACK -->

                        <div
                            id="imageFallback"
                            class="<?= !empty($product['image']) ? 'hidden' : '' ?> text-center text-slate-400"
                        >

                            <div class="text-7xl mb-3">
                                🩺
                            </div>

                            <p class="text-sm">
                                Equipment Image
                            </p>

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- PRICE BOXES -->
                    <!-- ================================= -->

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border-t border-slate-100">


                        <!-- PURCHASE -->

                        <div class="bg-white rounded-xl border border-slate-200 p-4">

                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                Purchase Price
                            </p>

                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">

                                <?php if ($purchasePrice !== null): ?>

                                    ₹<?= htmlspecialchars($purchasePrice) ?>

                                <?php else: ?>

                                    Contact Us

                                <?php endif; ?>

                            </p>

                            <p class="text-[10px] text-slate-400 mt-1">
                                Final price may vary by selected model
                            </p>

                        </div>



                        <!-- RENT -->

                        <div class="bg-white rounded-xl border border-slate-200 p-4">

                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                Rental Price
                            </p>

                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">

                                <?php if ($rentalPrice !== null): ?>

                                    ₹<?= htmlspecialchars($rentalPrice) ?>

                                    <?php if (!empty($product['rental_period'])): ?>

                                        <span class="text-xs font-semibold text-slate-500">
                                            / <?= htmlspecialchars($product['rental_period']) ?>
                                        </span>

                                    <?php endif; ?>

                                <?php else: ?>

                                    Contact Us

                                <?php endif; ?>

                            </p>

                            <p class="text-[10px] text-slate-400 mt-1">
                                Rental terms subject to availability
                            </p>

                        </div>


                    </div>

                </div>

            </div>



            <!-- ========================================= -->
            <!-- BOOKING CARD -->
            <!-- ========================================= -->

            <aside class="lg:col-span-4 lg:sticky lg:top-6">


                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


                    <!-- HEADER -->

                    <div class="bg-teal-600 text-white px-5 py-4">

                        <h2 class="font-bold text-lg">
                            Book Equipment
                        </h2>

                        <p class="text-xs text-teal-50 mt-1">
                            Submit your details and select rent or purchase.
                        </p>

                    </div>



                    <!-- FORM -->

                    <form
                        id="bookingForm"
                        class="p-5 space-y-4"
                    >


                        <!-- NAME -->

                        <div>

                            <label
                                for="name"
                                class="block text-xs font-semibold text-slate-700 mb-1.5"
                            >
                                Name
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                placeholder="Enter your name"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100"
                            >

                        </div>



                        <!-- MOBILE -->

                        <div>

                            <label
                                for="mobile"
                                class="block text-xs font-semibold text-slate-700 mb-1.5"
                            >
                                Mobile Number
                            </label>

                            <input
                                id="mobile"
                                name="mobile"
                                type="tel"
                                inputmode="numeric"
                                maxlength="10"
                                required
                                placeholder="Enter 10-digit mobile number"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100"
                            >

                        </div>



                        <!-- CITY -->

                        <div>

                            <label
                                for="city"
                                class="block text-xs font-semibold text-slate-700 mb-1.5"
                            >
                                City
                            </label>

                            <select
                                id="city"
                                name="city"
                                required
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm bg-white outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100"
                            >

                                <option value="">
                                    Select City
                                </option>

                                <option>Nashik</option>
                                <option>Mumbai</option>
                                <option>Delhi</option>
                                <option>Bangalore</option>
                                <option>Kolkata</option>
                                <option>Hyderabad</option>
                                <option>Chennai</option>
                                <option>Other</option>

                            </select>

                        </div>



                        <!-- ================================= -->
                        <!-- BOOKING TYPE -->
                        <!-- ================================= -->

                        <fieldset>

                            <legend class="block text-xs font-semibold text-slate-700 mb-2">
                                Booking Type
                            </legend>


                            <div class="grid grid-cols-2 gap-3">


                                <!-- RENT -->

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="booking_type"
                                        value="rental"
                                        class="peer sr-only"
                                        checked
                                    >

                                    <span class="flex items-center justify-center gap-2 min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">

                                        Rent

                                    </span>

                                </label>



                                <!-- PURCHASE -->

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="booking_type"
                                        value="purchase"
                                        class="peer sr-only"
                                    >

                                    <span class="flex items-center justify-center gap-2 min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">

                                        Purchase

                                    </span>

                                </label>


                            </div>

                        </fieldset>



                        <!-- ================================= -->
                        <!-- SELECTED EQUIPMENT -->
                        <!-- ================================= -->

                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">


                            <div class="flex justify-between gap-4 text-xs">

                                <span class="text-slate-500">
                                    Selected equipment
                                </span>

                                <span class="font-semibold text-slate-800 text-right">

                                    <?= htmlspecialchars($product['name']) ?>

                                </span>

                            </div>



                            <div class="flex justify-between gap-4 mt-2 text-sm">

                                <span class="font-semibold text-slate-700">
                                    Amount
                                </span>

                                <span
                                    id="selectedAmount"
                                    class="font-extrabold text-teal-700"
                                >

                                    <?php if ($rentalPrice !== null): ?>

                                        ₹<?= htmlspecialchars($rentalPrice) ?>

                                    <?php else: ?>

                                        Contact Us

                                    <?php endif; ?>

                                </span>

                            </div>


                        </div>



                        <!-- ================================= -->
                        <!-- CONSENT -->
                        <!-- ================================= -->

                        <label class="flex items-start gap-2 cursor-pointer">

                            <input
                                type="checkbox"
                                id="consent"
                                required
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-[11px] leading-relaxed text-slate-500">

                                I agree to be contacted regarding this equipment booking and understand that final rental/purchase terms will be confirmed by the service team.

                            </span>

                        </label>



                        <!-- ================================= -->
                        <!-- BOOK BUTTON -->
                        <!-- ================================= -->

                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 min-h-11 px-5 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-bold transition-colors"
                        >

                            Book Now

                            <span>→</span>

                        </button>



                        <!-- MESSAGE -->

                        <p
                            id="bookingMessage"
                            class="hidden text-xs text-teal-700 bg-teal-50 border border-teal-100 rounded-lg p-3"
                        >

                            This is currently a UI-only booking form. Payment integration will be connected after the booking flow is finalized.

                        </p>


                    </form>

                </div>



                <!-- ========================================= -->
                <!-- SERVICES -->
                <!-- ========================================= -->

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mt-5 p-5">


                    <div class="border-b-2 border-teal-600 pb-3 mb-3">

                        <h3 class="font-bold text-slate-900">
                            Portea Services
                        </h3>

                    </div>


                    <div class="divide-y divide-slate-100 text-xs font-medium">

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Elder Care
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Trained Attendant
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Physiotherapy
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Critical Care
                        </a>

                        <a
                            href="medical-equipment.php"
                            class="block py-2.5 text-teal-700 font-bold"
                        >
                            Medical Equipment
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Nursing
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Doctor Consultation
                        </a>

                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">
                            Mother & Baby Care
                        </a>

                    </div>

                </div>


            </aside>

        </section>



        <!-- ========================================= -->
        <!-- DESCRIPTION -->
        <!-- ========================================= -->

        <section class="grid grid-cols-1 lg:grid-cols-8 gap-7 mt-10">


            <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">


                <!-- DESCRIPTION -->

                <div class="border-l-4 border-teal-600 pl-4 mb-7">

                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                        Description
                    </h2>

                </div>


                <?php if (!empty($product['description'])): ?>

                    <p class="text-sm leading-7 text-slate-600">

                        <?= nl2br(htmlspecialchars($product['description'])) ?>

                    </p>

                <?php elseif (!empty($product['short_description'])): ?>

                    <p class="text-sm leading-7 text-slate-600">

                        <?= nl2br(htmlspecialchars($product['short_description'])) ?>

                    </p>

                <?php else: ?>

                    <p class="text-sm leading-7 text-slate-500">
                        Equipment details will be provided by our service team.
                    </p>

                <?php endif; ?>



                <!-- ================================= -->
                <!-- TECHNICAL SPECIFICATIONS -->
                <!-- ================================= -->

                <?php if (!empty($specifications)): ?>

                    <div class="mt-8">

                        <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">

                            Technical Specifications

                        </h3>


                        <ul class="mt-4 space-y-2 text-sm text-slate-600 list-disc pl-5">

                            <?php foreach ($specifications as $specification): ?>

                                <li>
                                    <?= htmlspecialchars($specification) ?>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                <?php endif; ?>



                <!-- ================================= -->
                <!-- BRANDS -->
                <!-- ================================= -->

                <?php if ($brands !== ''): ?>

                    <div class="mt-8">

                        <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">

                            Brands & Models Available

                        </h3>


                        <p class="mt-4 text-sm text-slate-600 leading-7">

                            <?= nl2br(htmlspecialchars($brands)) ?>

                        </p>

                    </div>

                <?php endif; ?>



                <!-- ================================= -->
                <!-- FAQ -->
                <!-- ================================= -->

                <div class="mt-10">

                    <h3 class="text-xl font-bold text-slate-900 border-l-4 border-teal-600 pl-3">

                        FAQs

                    </h3>


                    <div class="mt-5 space-y-3">


                        <!-- FAQ 1 -->

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">

                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">

                                What is this medical equipment used for?

                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">
                                    +
                                </span>

                            </summary>


                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">

                                Please refer to the equipment description and technical specifications above. Our service team can also help you understand whether this equipment is suitable for your requirement.

                            </div>

                        </details>



                        <!-- FAQ 2 -->

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">

                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">

                                What specifications does this equipment have?

                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">
                                    +
                                </span>

                            </summary>


                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">

                                The technical specifications for the selected equipment are listed in the Technical Specifications section above.

                            </div>

                        </details>



                        <!-- FAQ 3 -->

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">

                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">

                                Is the equipment available for rent and purchase?

                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">
                                    +
                                </span>

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



                        <!-- FAQ 4 -->

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">

                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">

                                Is home delivery available?

                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">
                                    +
                                </span>

                            </summary>


                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">

                                Delivery availability depends on location and equipment. The service team will confirm delivery details after receiving the booking request.

                            </div>

                        </details>


                    </div>

                </div>


            </div>



            <!-- ========================================= -->
            <!-- RELATED -->
            <!-- ========================================= -->

            <aside class="lg:col-span-2">


                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 lg:sticky lg:top-6">


                    <h3 class="font-bold text-slate-900 text-base border-b-2 border-teal-600 pb-3">

                        Also Read About

                    </h3>


                    <a
                        href="equipment-list.php?category=<?= urlencode($product['category_slug']) ?>"
                        class="block py-3 text-xs text-teal-700 hover:underline border-b border-slate-100"
                    >

                        More <?= htmlspecialchars($product['category_name']) ?>

                    </a>


                    <a
                        href="medical-equipment.php"
                        class="block py-3 text-xs text-teal-700 hover:underline border-b border-slate-100"
                    >

                        All Medical Equipment

                    </a>


                    <a
                        href="#"
                        class="block py-3 text-xs text-teal-700 hover:underline"
                    >

                        Equipment Rental Agreement

                    </a>


                </div>

            </aside>


        </section>



        <!-- ========================================= -->
        <!-- TESTIMONIALS -->
        <!-- ========================================= -->

        <section class="mt-14 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-10">


            <div class="text-center mb-8">

                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900">

                    Patient Testimonials

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Real experiences from families we care for

                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                <article class="border border-slate-200 border-l-4 border-l-teal-600 rounded-xl p-5">

                    <div class="text-teal-600 text-2xl">
                        “
                    </div>

                    <p class="text-sm text-slate-600 leading-6">

                        The service was very helpful and the equipment was delivered on time. The team explained the usage clearly.

                    </p>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-xs font-bold text-slate-800">
                            M. Poornima
                        </p>

                    </div>

                </article>



                <article class="border border-slate-200 border-l-4 border-l-teal-600 rounded-xl p-5">

                    <div class="text-teal-600 text-2xl">
                        “
                    </div>

                    <p class="text-sm text-slate-600 leading-6">

                        The booking process was simple and the support team followed up quickly when we needed assistance.

                    </p>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-xs font-bold text-slate-800">
                            Bhaskar Pramanik
                        </p>

                    </div>

                </article>



                <article class="border border-slate-200 border-l-4 border-l-teal-600 rounded-xl p-5">

                    <div class="text-teal-600 text-2xl">
                        “
                    </div>

                    <p class="text-sm text-slate-600 leading-6">

                        Very helpful team and good communication throughout the booking and delivery process.

                    </p>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-xs font-bold text-slate-800">
                            Narayana Murthy K
                        </p>

                    </div>

                </article>


            </div>

        </section>


    </div>

</div>



<!-- ========================================= -->
<!-- BOOKING JAVASCRIPT -->
<!-- ========================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    const form = document.getElementById('bookingForm');

    const amount = document.getElementById('selectedAmount');

    const message = document.getElementById('bookingMessage');


    if (!form || !amount) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prices From Database
    |--------------------------------------------------------------------------
    */

    const rentalPrice = <?= json_encode($rentalPrice !== null ? '₹' . $rentalPrice : 'Contact Us') ?>;

    const purchasePrice = <?= json_encode($purchasePrice !== null ? '₹' . $purchasePrice : 'Contact Us') ?>;


    /*
    |--------------------------------------------------------------------------
    | Change Amount When Booking Type Changes
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('input[name="booking_type"]')
        .forEach(function (radio) {

            radio.addEventListener('change', function () {

                if (this.value === 'purchase') {

                    amount.textContent = purchasePrice;

                } else {

                    amount.textContent = rentalPrice;

                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Booking Form
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        event.preventDefault();


        const mobileInput = document.getElementById('mobile');

        const mobile = mobileInput.value.trim();


        /*
        |--------------------------------------------------------------------------
        | Mobile Validation
        |--------------------------------------------------------------------------
        */

        if (!/^[0-9]{10}$/.test(mobile)) {

            alert('Please enter a valid 10-digit mobile number.');

            mobileInput.focus();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Current UI-only Message
        |--------------------------------------------------------------------------
        */

        message.classList.remove('hidden');

        message.textContent =
            'This is currently a UI-only booking form. Payment integration will be connected after the booking flow is finalized.';


        message.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });

    });


});

</script>


<?php include 'footer.php'; ?>