<?php
$pageTitle = "Home - Jivhala Healthcare Services Private Limited";
include 'header.php';
?>

<!-- ================= SECTION 1: HERO ================= -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden py-14 md:py-20 px-4 sm:px-6 lg:px-12 xl:px-20 bg-[#FAF7F2]">
  <div class="absolute inset-0 z-0">
    <img
      src="img/homehero.png"
      alt="Jivhala Healthcare Background"
      class="w-full h-full object-cover object-center"
      onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1600&auto=format&fit=crop'" />
    <div class="absolute inset-0 bg-gradient-to-r from-[#FAF7F2] via-[#FAF7F2]/80 to-transparent"></div>
  </div>

  <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
    <div class="lg:col-span-7 space-y-6">

      <div>
        <span class="inline-flex items-center gap-2 text-xs font-bold tracking-widest text-[#008080] uppercase bg-teal-50 border border-teal-200 px-3.5 py-1.5 rounded-full shadow-2xs">
          Your Trusted Partner in Healthcare, Healing &amp; Happiness
        </span>
      </div>

      <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#1a2d37] font-serif leading-tight tracking-tight">
        Professional Medical Care in the <br class="hidden sm:inline" />
        <span class="relative inline-block text-teal-800">
          Comfort of Your Home
          <svg class="absolute -bottom-2 left-0 w-full h-3 text-[#A6292F]" viewBox="0 0 320 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 14C90 4 230 4 315 14" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
          </svg>
        </span>
      </h1>

      <p class="text-slate-700 font-medium text-sm sm:text-base lg:text-lg max-w-xl leading-relaxed">
        Compassionate patient caretakers, certified GNM/ANM nurses, elder care attendants, and hospital manpower solutions delivered with trust and human touch.
      </p>

      <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
        <a href="book-now.php" class="inline-flex items-center justify-center bg-[#A6292F] hover:bg-[#8e2126] text-white px-8 py-3.5 rounded-full text-sm font-bold transition-all shadow-md hover:shadow-lg active:scale-95">
          Book Care Now
        </a>

        <a href="tel:+919860390012" class="inline-flex items-center justify-center gap-3 bg-[#0F766E] hover:bg-[#0d615b] text-white font-bold py-2.5 px-6 rounded-full border border-teal-600 shadow-md transition-all">
          <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
          </div>
          <span class="text-sm tracking-wide">+91 9860390012</span>
        </a>
      </div>

    </div>
  </div>
</section>


<!-- ================= SECTION 2: SERVICES OFFERED ================= -->
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 max-w-7xl mx-auto">
  <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14 space-y-2">
    <span class="text-xs font-bold tracking-widest text-[#008080] uppercase block">What We Deliver</span>
    <h2 class="text-2xl sm:text-4xl font-extrabold text-[#1a2d37] font-serif">
      Healthcare &amp; Support Services
    </h2>
    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
      Safe, supervised, and professional care delivered directly to your home or healthcare facility.
    </p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

    <!-- Service 1 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          🩺
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Patient Care &amp; Attendants</h3>
          <p class="text-[11px] text-slate-500 truncate">Male/Female trained caretakers</p>
        </div>
      </div>
      <a href="book-now.php?service=patient-care" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

    <!-- Service 2 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          💉
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Nursing Services</h3>
          <p class="text-[11px] text-slate-500 truncate">Certified GNM &amp; ANM staff</p>
        </div>
      </div>
      <a href="book-now.php?service=nursing" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

    <!-- Service 3 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          🧓
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Elder Care Services</h3>
          <p class="text-[11px] text-slate-500 truncate">Compassionate daily living support</p>
        </div>
      </div>
      <a href="book-now.php?service=elder-care" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

    <!-- Service 4 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          👶
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Baby Care &amp; Japa Maid</h3>
          <p class="text-[11px] text-slate-500 truncate">Post-natal mother &amp; baby support</p>
        </div>
      </div>
      <a href="book-now.php?service=baby-care" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

    <!-- Service 5 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          🏥
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Hospital Manpower Staffing</h3>
          <p class="text-[11px] text-slate-500 truncate">Ward boys, ayas, &amp; attendants</p>
        </div>
      </div>
      <a href="book-now.php?service=manpower" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

    <!-- Service 6 -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs hover:shadow-md transition flex items-center justify-between gap-4">
      <div class="flex items-center gap-3.5 min-w-0">
        <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0 font-bold">
          🛏️
        </div>
        <div class="min-w-0">
          <h3 class="font-bold text-slate-800 text-sm truncate">Medical Equipment</h3>
          <p class="text-[11px] text-slate-500 truncate">Rental &amp; sales for home ICU</p>
        </div>
      </div>
      <a href="book-now.php?service=medical-equipment" class="text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 px-3.5 py-1.5 rounded-full shrink-0 transition">Book</a>
    </div>

  </div>
</section>


<!-- ================= SECTION 3: HOW IT WORKS ================= -->
<section class="bg-[#092B28] text-white py-16 sm:py-20 px-4 sm:px-6 lg:px-12 relative overflow-hidden">
  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16 space-y-2">
      <span class="text-xs font-bold tracking-widest text-teal-300 uppercase block">Simple &amp; Dependable</span>
      <h2 class="text-2xl sm:text-4xl font-extrabold text-white font-serif">How Jivhala Works</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <div class="bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 relative">
        <span class="text-4xl font-black text-teal-700/40 font-serif">01</span>
        <h3 class="text-base font-bold text-white mt-2 mb-1">Share Your Requirement</h3>
        <p class="text-xs text-teal-100/70 leading-relaxed">
          Reach out through our online booking form or directly call our coordination desk.
        </p>
      </div>

      <div class="bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 relative">
        <span class="text-4xl font-black text-teal-700/40 font-serif">02</span>
        <h3 class="text-base font-bold text-white mt-2 mb-1">Care &amp; Profile Matching</h3>
        <p class="text-xs text-teal-100/70 leading-relaxed">
          We understand patient needs and assign verified nurses, caretakers, or staffing personnel.
        </p>
      </div>

      <div class="bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 relative">
        <span class="text-4xl font-black text-teal-700/40 font-serif">03</span>
        <h3 class="text-base font-bold text-white mt-2 mb-1">Service Begins</h3>
        <p class="text-xs text-teal-100/70 leading-relaxed">
          Trained staff arrives at your home or hospital ready to provide disciplined assistance.
        </p>
      </div>

      <div class="bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 relative">
        <span class="text-4xl font-black text-teal-700/40 font-serif">04</span>
        <h3 class="text-base font-bold text-white mt-2 mb-1">Supervision &amp; Feedback</h3>
        <p class="text-xs text-teal-100/70 leading-relaxed">
          Continuous coordination, feedback loops, and replacement support whenever needed.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- ================= SECTION 4: STATS & HIGHLIGHTS ================= -->
<section class="bg-[#FAF7F2] border-y border-slate-200 py-10 px-4 sm:px-6 lg:px-12">
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y sm:divide-y-0 md:divide-x divide-slate-200">

      <div class="p-2 space-y-1">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#008080]">16+ Years</h3>
        <p class="text-[11px] sm:text-xs font-bold text-slate-600 uppercase tracking-wider">Field Experience</p>
      </div>

      <div class="p-2 space-y-1">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#008080]">2010</h3>
        <p class="text-[11px] sm:text-xs font-bold text-slate-600 uppercase tracking-wider">Roots in Helping Hands</p>
      </div>

      <div class="p-2 space-y-1">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#008080]">100%</h3>
        <p class="text-[11px] sm:text-xs font-bold text-slate-600 uppercase tracking-wider">Verified Personnel</p>
      </div>

      <div class="p-2 space-y-1">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#008080]">24/7</h3>
        <p class="text-[11px] sm:text-xs font-bold text-slate-600 uppercase tracking-wider">Caregiver Coordination</p>
      </div>

    </div>
  </div>
</section>


<!-- ================= SECTION 5: FAQS (NATIVE DETAILS ACCORDION) ================= -->
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

      <div class="lg:col-span-4 space-y-4">
        <span class="text-xs font-bold tracking-widest text-[#008080] uppercase block">Need Assistance?</span>
        <h2 class="text-2xl sm:text-4xl font-extrabold text-[#1a2d37] font-serif">Frequently Asked Questions</h2>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
          Common queries answered regarding our caregivers, verified nurses, and service terms.
        </p>

        <div class="bg-[#FAF7F2] rounded-2xl p-6 border border-slate-200 mt-6 space-y-2">
          <h4 class="text-sm font-bold text-slate-900">Need specific help?</h4>
          <p class="text-xs text-slate-600">Speak directly with our care coordinator.</p>
          <a href="tel:+919860390012" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#008080] hover:underline pt-2">
            📞 +91 9860390012
          </a>
        </div>
      </div>

      <div class="lg:col-span-8 space-y-3">

        <details class="group bg-[#FAF7F2] rounded-2xl border border-slate-200 p-5 transition-all">
          <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-800 text-xs sm:text-sm select-none">
            <span>What services does Jivhala Healthcare provide?</span>
            <span class="text-teal-700 font-bold transition-transform duration-200 group-open:rotate-45 text-base">+</span>
          </summary>
          <p class="mt-3 pt-3 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
            We provide patient care attendants, elder care services, certified GNM/ANM nurses, baby care &amp; Japa maid services, physiotherapy, medical equipment rental/sales, and institutional hospital staffing.
          </p>
        </details>

        <details class="group bg-white rounded-2xl border border-slate-200 p-5 transition-all">
          <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-800 text-xs sm:text-sm select-none">
            <span>Are the caregivers and nurses background-verified?</span>
            <span class="text-teal-700 font-bold transition-transform duration-200 group-open:rotate-45 text-base">+</span>
          </summary>
          <p class="mt-3 pt-3 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
            Yes. All personnel go through rigorous verification, document checks, and skill assessments before being deployed to homes or healthcare institutions.
          </p>
        </details>

        <details class="group bg-white rounded-2xl border border-slate-200 p-5 transition-all">
          <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-800 text-xs sm:text-sm select-none">
            <span>Can Jivhala provide shift replacement if a staff member takes leave?</span>
            <span class="text-teal-700 font-bold transition-transform duration-200 group-open:rotate-45 text-base">+</span>
          </summary>
          <p class="mt-3 pt-3 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
            Yes, we provide staff replacement and active shift management to guarantee continuous care without disruption for families and hospitals.
          </p>
        </details>

        <details class="group bg-white rounded-2xl border border-slate-200 p-5 transition-all">
          <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-800 text-xs sm:text-sm select-none">
            <span>Do you support NRIs looking after parents in India?</span>
            <span class="text-teal-700 font-bold transition-transform duration-200 group-open:rotate-45 text-base">+</span>
          </summary>
          <p class="mt-3 pt-3 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
            Yes. We regularly coordinate with NRI clients living abroad who require reliable, supervised, and accountable care for their elderly parents in India.
          </p>
        </details>

      </div>

    </div>
  </div>
</section>


<!-- ================= SECTION 6: CTA FOOTER BANNER ================= -->
<section class="bg-[#0A3638] text-white py-14 sm:py-16 px-4 sm:px-6 lg:px-12">
  <div class="max-w-4xl mx-auto text-center space-y-4">
    <h2 class="text-2xl sm:text-4xl font-extrabold font-serif tracking-tight">
      Ready to Bring Compassionate Care Home?
    </h2>
    <p class="text-xs sm:text-sm text-teal-100/80 max-w-xl mx-auto leading-relaxed">
      Speak with our team to arrange home attendants, nurses, or institutional manpower.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
      <a href="book-now.php" class="w-full sm:w-auto bg-[#A6292F] hover:bg-[#8e2126] text-white font-bold text-xs px-8 py-3.5 rounded-xl shadow-lg transition text-center">
        Book an Attendant
      </a>
      <a href="tel:+919860390012" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs font-bold text-white hover:text-teal-200 transition py-3.5 px-4">
        <span>📞 +91 9860390012</span>
      </a>
    </div>

    <p class="text-xs text-teal-200/60 pt-2">
      Flat no. S-3, Shobha Tower, near Podar International School, Datala, Chandrapur - 442406
    </p>
  </div>
</section>

<?php include 'footer.php'; ?>