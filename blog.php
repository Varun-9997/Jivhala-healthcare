<?php 
  $pageTitle = "Healthcare Blogs - Jivhala Healthcare Services";
  include 'header.php'; 
?>

<!-- ================= SECTION 1: HERO BANNER ================= -->
<section class="bg-[#00797b] text-white py-12 sm:py-16 px-4 text-center border-b border-teal-800">
  <div class="max-w-4xl mx-auto space-y-4">
    <h1 class="text-3xl sm:text-5xl font-extrabold font-serif tracking-tight">
      Healthcare Insights &amp; Care Guidance
    </h1>
    <p class="text-teal-100 text-xs sm:text-sm md:text-base font-medium leading-relaxed max-w-2xl mx-auto">
      Practical information on home nursing, elder care, rehabilitation, patient attendants, medical equipment, and hospital staffing.
    </p>

    <div class="pt-2">
      <span class="inline-block bg-teal-800/60 border border-teal-400/40 text-teal-100 text-[11px] sm:text-xs font-semibold px-4 py-1.5 rounded-full shadow-xs">
        Practical guidance from home care and healthcare support services
      </span>
    </div>
  </div>
</section>

<!-- ================= SECTION 2: CATEGORIES & BLOG GRID ================= -->
<section class="py-10 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

  <!-- Category Filter Pills -->
  <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 mb-10 text-xs font-medium" id="blogFilterBar">
    <button type="button" data-filter="all" class="filter-btn active bg-[#00797b] text-white px-4 py-1.5 rounded-full shadow-xs font-bold transition active:scale-95">
      All Articles
    </button>
    <button type="button" data-filter="elder-care" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Elder Care
    </button>
    <button type="button" data-filter="nursing" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Home Nursing
    </button>
    <button type="button" data-filter="bedridden" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Patient Attendants &amp; Bedridden Care
    </button>
    <button type="button" data-filter="mobility" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Mobility &amp; Rehabilitation
    </button>
    <button type="button" data-filter="staffing" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Hospital Staffing
    </button>
    <button type="button" data-filter="equipment" class="filter-btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3.5 py-1.5 rounded-full shadow-2xs transition-colors">
      Medical Equipment &amp; ICU
    </button>
  </div>

  <!-- Blog Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7" id="blogGrid">

    <!-- Card 1 -->
    <article data-category="elder-care" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/image21.jpg" alt="Caregiver assisting senior with meal" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Elder Care
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            Nutritional Care &amp; Dignified Feeding for Seniors
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            February 15, 2026
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Gentle bedside support can help seniors receive appropriate hydration, nutrition, and prescribed medicines safely and with dignity.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

    <!-- Card 2 -->
    <article data-category="nursing" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/image13.jpg" alt="Nurse checking blood pressure of elderly patient" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Home Nursing
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            The Importance of Routine Vitals Monitoring at Home
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            January 28, 2026
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Regular monitoring of blood pressure, pulse, temperature, and oxygen saturation can help caregivers and clinicians identify changes that may require attention.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

    <!-- Card 3 -->
    <article data-category="mobility" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/image9.jpg" alt="Attendant supporting patient with walker" class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Mobility &amp; Rehabilitation
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            Rebuilding Post-Surgery Walking Confidence
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            January 14, 2026
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Recovery after hip or knee procedures often requires safe mobility support and adherence to the rehabilitation plan provided by the treating clinical team.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

    <!-- Card 4 -->
    <article data-category="bedridden" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/pinkgilr.jpg" alt="Caretaker supporting bedridden elderly man" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Bedridden Care
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            Preventing Bedsores &amp; Complications in Long-Term Care
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            December 22, 2025
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Immobile patients may need individualized positioning, skin care, hygiene, nutrition, and regular monitoring to help reduce the risk of pressure injuries and other complications.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

    <!-- Card 5 -->
    <article data-category="equipment" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/IMG-20260905-WA0009.jpg" alt="Wheelchair and home medical equipment" class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Medical Equipment &amp; ICU
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            Selecting the Right Wheelchairs &amp; Home ICU Beds
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            November 18, 2025
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Understanding the purpose and suitability of hospital beds, wheelchairs, oxygen equipment, and suction devices can help families plan home-based care more effectively.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

    <!-- Card 6 -->
    <article data-category="staffing" class="blog-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition duration-300">
      <div>
        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 border-b border-slate-100">
          <img src="img/wardboy.jpg" alt="Hospital ward attendant" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5 space-y-2">
          <span class="inline-block bg-teal-50 text-teal-700 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md mb-1">
            Hospital Staffing
          </span>
          <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
            Supporting Hospital Staffing &amp; Patient Services
          </h3>
          <p class="text-[11px] font-semibold text-slate-400">
            October 30, 2025
          </p>
          <p class="text-xs text-slate-600 leading-relaxed">
            Reliable ward attendants, OT support staff, housekeeping personnel, and other healthcare support workers can contribute to smoother day-to-day hospital operations.
          </p>
        </div>
      </div>
      <div class="px-5 pb-5">
        <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition">
          Read Article <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>

  </div>
</section>

<!-- ================= JAVASCRIPT CATEGORY FILTERING ================= -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const filterBtns = document.querySelectorAll("#blogFilterBar .filter-btn");
    const blogCards = document.querySelectorAll("#blogGrid .blog-card");

    filterBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        const selected = this.getAttribute("data-filter");

        // Update button styles
        filterBtns.forEach(function(button) {
          button.classList.remove("bg-[#00797b]", "text-white", "font-bold");
          button.classList.add("bg-white", "border", "border-slate-200", "text-slate-700");
        });

        this.classList.remove("bg-white", "border", "border-slate-200", "text-slate-700");
        this.classList.add("bg-[#00797b]", "text-white", "font-bold");

        // Toggle visibility of blog cards
        blogCards.forEach(function(card) {
          const category = card.getAttribute("data-category");

          if (selected === "all" || category === selected) {
            card.style.display = "flex";
          } else {
            card.style.display = "none";
          }
        });
      });
    });
  });
</script>

<?php include 'footer.php'; ?>