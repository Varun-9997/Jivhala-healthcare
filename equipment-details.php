<?php
include 'header.php';

/*
|--------------------------------------------------------------------------
| Static equipment data for UI development
|--------------------------------------------------------------------------
| Later, this data can come from a database/API.
*/

$products = [
    1 => [
        'category' => 'Oxygen Concentrators',
        'name' => 'Oxygen Concentrator 5 LPM',
        'image' => 'assets/images/equipment/oxygen-concentrator-5-lpm.jpg',
        'purchase_price' => '₹45,000',
        'rental_price' => '₹4,500',
        'rental_period' => '30 days',
        'description' => 'A compact oxygen concentrator designed to provide supplemental oxygen for patients requiring oxygen therapy at home. It is suitable for routine home-care requirements and can be used for extended periods as advised by a healthcare professional.',
        'specifications' => [
            'Continuous oxygen flow suitable for home use',
            'Oxygen purity suitable for supplemental oxygen therapy',
            'Compact design for convenient home use',
            'Low-maintenance operation',
            'Easy-to-use controls'
        ],
        'brands' => 'Multiple brands and models available depending on requirement and availability.'
    ],
    2 => [
        'category' => 'Oxygen Concentrators',
        'name' => 'Oxygen Concentrator 8 LPM',
        'image' => 'assets/images/equipment/oxygen-concentrator-8-lpm.jpg',
        'purchase_price' => '₹55,000',
        'rental_price' => '₹6,000',
        'rental_period' => '30 days',
        'description' => 'An 8 LPM oxygen concentrator intended for patients who require a higher oxygen flow. The unit is designed for dependable home-care use.',
        'specifications' => [
            'Up to 8 LPM oxygen flow',
            'Suitable for continuous home use',
            'Simple operating controls',
            'Compact equipment footprint',
            'Designed for home-care requirements'
        ],
        'brands' => 'Multiple brands and models available depending on requirement and availability.'
    ],
    3 => [
        'category' => 'Oxygen Concentrators',
        'name' => 'Oxygen Concentrator 9/10 LPM',
        'image' => 'assets/images/equipment/oxygen-concentrator-9-10-lpm.jpg',
        'purchase_price' => '₹59,000 - ₹64,000',
        'rental_price' => '₹7,300',
        'rental_period' => '30 days',
        'description' => 'The Oxygen Concentrator 9/10 LPM is a stationary oxygen concentrator designed to provide supplemental oxygen. It is intended for patients who require higher oxygen flow as part of home-care support.',
        'specifications' => [
            'Provides continuous flow of approximately 0.5–10 LPM',
            'Oxygen purity suitable for supplemental oxygen therapy',
            'Designed for continuous home use',
            'Suitable for higher-flow oxygen requirements',
            'Easy-to-operate controls',
            'Noise level and power consumption vary by model'
        ],
        'brands' => 'Oxymed 10 LPM OC, Yuwell 10 LPM OC, Devilbiss 10 LPM and other models may be available.'
    ],
    4 => [
        'category' => 'Oxygen Concentrators',
        'name' => 'Portable Oxygen Concentrator',
        'image' => 'assets/images/equipment/portable-oxygen-concentrator.jpg',
        'purchase_price' => '₹75,000',
        'rental_price' => '₹8,000',
        'rental_period' => '30 days',
        'description' => 'A portable oxygen solution designed for users who need greater mobility while receiving supplemental oxygen.',
        'specifications' => [
            'Portable design',
            'Easy-to-carry form factor',
            'Suitable for supplemental oxygen use',
            'Rechargeable operation on supported models',
            'Model-specific oxygen output'
        ],
        'brands' => 'Availability depends on model and stock.'
    ],
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 3;
$product = $products[$id] ?? $products[3];

$rentAmount = (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', $product['rental_price']));
$purchaseNumbers = preg_replace('/[^0-9\-]/', '', str_replace(',', '', $product['purchase_price']));
?>

<div class="bg-[#f8f6ef] min-h-screen py-8 sm:py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="medical-equipment.php" class="hover:text-teal-600">Home</a>
            <span>›</span>
            <a href="medical-equipment.php" class="hover:text-teal-600">Medical Equipment</a>
            <span>›</span>
            <a href="equipment-list.php?category=oxygen-concentrators" class="hover:text-teal-600">
                <?= htmlspecialchars($product['category']) ?>
            </a>
            <span>›</span>
            <span class="text-slate-700"><?= htmlspecialchars($product['name']) ?></span>
        </div>

        <!-- Product + Booking -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

            <!-- Product -->
            <div class="lg:col-span-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-6">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="h-[320px] sm:h-[430px] bg-white flex items-center justify-center p-6 sm:p-10">
                        <img
                            src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="max-h-full max-w-full object-contain"
                            onerror="this.style.display='none'; document.getElementById('imageFallback').classList.remove('hidden');"
                        >

                        <div id="imageFallback" class="hidden text-center text-slate-400">
                            <div class="text-7xl mb-3">🩺</div>
                            <p class="text-sm">Equipment Image</p>
                        </div>
                    </div>

                    <!-- Price boxes -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border-t border-slate-100">

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                Purchase Price
                            </p>
                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">
                                <?= htmlspecialchars($product['purchase_price']) ?>
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1">
                                Final price may vary by selected model
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                Rental Price
                            </p>
                            <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1">
                                <?= htmlspecialchars($product['rental_price']) ?>
                                <span class="text-xs font-semibold text-slate-500">/ <?= htmlspecialchars($product['rental_period']) ?></span>
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1">
                                Rental terms subject to availability
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Booking Card -->
            <aside class="lg:col-span-4 lg:sticky lg:top-6">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="bg-teal-600 text-white px-5 py-4">
                        <h2 class="font-bold text-lg">Book Equipment</h2>
                        <p class="text-xs text-teal-50 mt-1">
                            Submit your details and select rent or purchase.
                        </p>
                    </div>

                    <form id="bookingForm" class="p-5 space-y-4">

                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
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

                        <div>
                            <label for="mobile" class="block text-xs font-semibold text-slate-700 mb-1.5">
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

                        <div>
                            <label for="city" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                City
                            </label>
                            <select
                                id="city"
                                name="city"
                                required
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm bg-white outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100"
                            >
                                <option value="">Select City</option>
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

                        <fieldset>
                            <legend class="block text-xs font-semibold text-slate-700 mb-2">
                                Booking Type
                            </legend>

                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="booking_type" value="rent" class="peer sr-only" checked>
                                    <span class="flex items-center justify-center gap-2 min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">
                                        Rent
                                    </span>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="booking_type" value="purchase" class="peer sr-only">
                                    <span class="flex items-center justify-center gap-2 min-h-11 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 transition">
                                        Purchase
                                    </span>
                                </label>
                            </div>
                        </fieldset>

                        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex justify-between gap-4 text-xs">
                                <span class="text-slate-500">Selected equipment</span>
                                <span class="font-semibold text-slate-800 text-right">
                                    <?= htmlspecialchars($product['name']) ?>
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 mt-2 text-sm">
                                <span class="font-semibold text-slate-700">Amount</span>
                                <span id="selectedAmount" class="font-extrabold text-teal-700">
                                    <?= htmlspecialchars($product['rental_price']) ?>
                                </span>
                            </div>
                        </div>

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

                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 min-h-11 px-5 py-3 bg-[#A6292F] hover:bg-[#8f2227] text-white rounded-xl text-sm font-bold transition-colors"
                        >
                            Book Now
                            <span>→</span>
                        </button>

                        <p id="bookingMessage" class="hidden text-xs text-teal-700 bg-teal-50 border border-teal-100 rounded-lg p-3">
                            This is currently a UI-only booking form. Payment integration will be connected after the booking flow is finalized.
                        </p>

                    </form>
                </div>

                <!-- Services -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mt-5 p-5">
                    <div class="border-b-2 border-teal-600 pb-3 mb-3">
                        <h3 class="font-bold text-slate-900">Portea Services</h3>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs font-medium">
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Elder Care</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Trained Attendant</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Physiotherapy</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Critical Care</a>
                        <a href="medical-equipment.php" class="block py-2.5 text-teal-700 font-bold">Medical Equipment</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Nursing</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Doctor Consultation</a>
                        <a href="#" class="block py-2.5 text-slate-600 hover:text-teal-600">Mother & Baby Care</a>
                    </div>
                </div>

            </aside>
        </section>

        <!-- Description -->
        <section class="grid grid-cols-1 lg:grid-cols-8 gap-7 mt-10">

            <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

                <div class="border-l-4 border-teal-600 pl-4 mb-7">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Description</h2>
                </div>

                <p class="text-sm leading-7 text-slate-600">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">
                        Technical Specifications
                    </h3>

                    <ul class="mt-4 space-y-2 text-sm text-slate-600 list-disc pl-5">
                        <?php foreach ($product['specifications'] as $specification): ?>
                            <li><?= htmlspecialchars($specification) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-bold text-slate-900 border-l-4 border-teal-600 pl-3">
                        Brands & Models Available
                    </h3>

                    <p class="mt-4 text-sm text-slate-600 leading-7">
                        <?= htmlspecialchars($product['brands']) ?>
                    </p>
                </div>

                <!-- FAQ -->
                <div class="mt-10">
                    <h3 class="text-xl font-bold text-slate-900 border-l-4 border-teal-600 pl-3">
                        FAQs
                    </h3>

                    <div class="mt-5 space-y-3">

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                What is an oxygen concentrator?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                An oxygen concentrator is a medical device that provides supplemental oxygen by concentrating oxygen from room air.
                            </div>
                        </details>

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                What is the maximum LPM available?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                Maximum oxygen flow depends on the specific model. Please check the specifications of the selected equipment or contact the service team.
                            </div>
                        </details>

                        <details class="group rounded-xl border border-slate-200 overflow-hidden">
                            <summary class="cursor-pointer flex justify-between items-center gap-4 p-4 font-bold text-sm text-slate-800">
                                Is the equipment available for rent and purchase?
                                <span class="text-teal-600 text-xl group-open:rotate-45 transition-transform">+</span>
                            </summary>
                            <div class="px-4 pb-4 text-sm leading-6 text-slate-600 border-t border-slate-100 pt-3">
                                Availability depends on the equipment model and current stock. The booking form lets you indicate whether you are interested in renting or purchasing.
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

            <!-- Related -->
            <aside class="lg:col-span-2">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 lg:sticky lg:top-6">
                    <h3 class="font-bold text-slate-900 text-base border-b-2 border-teal-600 pb-3">
                        Also Read About
                    </h3>

                    <a href="equipment-list.php?category=oxygen-concentrators"
                       class="block py-3 text-xs text-teal-700 hover:underline border-b border-slate-100">
                        Different Oxygen Concentrator Types
                    </a>

                    <a href="#" class="block py-3 text-xs text-teal-700 hover:underline border-b border-slate-100">
                        Equipment Usage & Care
                    </a>

                    <a href="#" class="block py-3 text-xs text-teal-700 hover:underline">
                        Equipment Rental Agreement
                    </a>
                </div>

            </aside>

        </section>

        <!-- Testimonials -->
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
                    <div class="text-teal-600 text-2xl">“</div>
                    <p class="text-sm text-slate-600 leading-6">
                        The service was very helpful and the equipment was delivered on time. The team explained the usage clearly.
                    </p>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-800">M. Poor­nima</p>
                    </div>
                </article>

                <article class="border border-slate-200 border-l-4 border-l-teal-600 rounded-xl p-5">
                    <div class="text-teal-600 text-2xl">“</div>
                    <p class="text-sm text-slate-600 leading-6">
                        The booking process was simple and the support team followed up quickly when we needed assistance.
                    </p>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-800">Bhaskar Pramanik</p>
                    </div>
                </article>

                <article class="border border-slate-200 border-l-4 border-l-teal-600 rounded-xl p-5">
                    <div class="text-teal-600 text-2xl">“</div>
                    <p class="text-sm text-slate-600 leading-6">
                        Very helpful team and good communication throughout the booking and delivery process.
                    </p>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-800">Narayana Murthy K</p>
                    </div>
                </article>

            </div>
        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bookingForm');
    const amount = document.getElementById('selectedAmount');
    const message = document.getElementById('bookingMessage');

    if (!form || !amount) return;

    const rentalPrice = <?= json_encode($product['rental_price']) ?>;
    const purchasePrice = <?= json_encode($product['purchase_price']) ?>;

    document.querySelectorAll('input[name="booking_type"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            amount.textContent = this.value === 'purchase' ? purchasePrice : rentalPrice;
        });
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const mobile = document.getElementById('mobile').value.trim();

        if (!/^[0-9]{10}$/.test(mobile)) {
            alert('Please enter a valid 10-digit mobile number.');
            return;
        }

        message.classList.remove('hidden');
        message.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
});
</script>

<?php include 'footer.php' ?>
