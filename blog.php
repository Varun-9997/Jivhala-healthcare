


    <title>Blog </title>

    <?php include 'header.php' ?>



  <!-- ================= SECTION 1: HEALTHCARE BLOGS HERO HEADER ================= -->
  <section class="bg-[#00797b] text-white py-12 sm:py-16 px-4 text-center border-b border-teal-800">
    <div class="max-w-4xl mx-auto space-y-4">
      <h1 class="text-3xl sm:text-5xl font-extrabold font-serif tracking-tight">
        Healthcare Blogs
      </h1>
      <p class="text-teal-100 text-xs sm:text-sm md:text-base font-medium leading-relaxed max-w-2xl mx-auto">
        Expert insights, health tips, and medical advice from our healthcare professionals
      </p>
      <div class="pt-2">
        <span class="inline-block bg-teal-800/60 border border-teal-400/40 text-teal-100 text-[11px] sm:text-xs font-semibold px-4 py-1.5 rounded-full shadow-xs">
          74 articles across 11 categories
        </span>
      </div>
    </div>
  </section>


  <!-- ================= SECTION 2: CATEGORY FILTERS, BLOG GRID & PAGINATION ================= -->
  <section class="py-8 sm:py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Filter Category Pills -->
    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 mb-6 text-xs font-medium">
      <button class="bg-[#00797b] text-white px-3.5 py-1.5 rounded-full shadow-xs flex items-center gap-1.5 font-bold transition-transform active:scale-95">
        All <span class="bg-teal-900/40 px-1.5 py-0.5 rounded-full text-[10px]">74</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Physiotherapy <span class="text-slate-400 text-[10px]">30</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Nursing <span class="text-slate-400 text-[10px]">20</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Elder Care <span class="text-slate-400 text-[10px]">8</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        New Born Baby Mother Care <span class="text-slate-400 text-[10px]">4</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Vaccination <span class="text-slate-400 text-[10px]">3</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Respiratory Care <span class="text-slate-400 text-[10px]">1</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Trained Attendants <span class="text-slate-400 text-[10px]">2</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Cardiac Care <span class="text-slate-400 text-[10px]">1</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Doctor Consultations <span class="text-slate-400 text-[10px]">1</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Nutrition Diet Consultation <span class="text-slate-400 text-[10px]">1</span>
      </button>
      <button class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3 py-1.5 rounded-full shadow-2xs flex items-center gap-1.5 transition-colors">
        Diabetes Care <span class="text-slate-400 text-[10px]">1</span>
      </button>
    </div>

    <!-- Article Counter Info -->
    <div class="mb-4 text-xs font-semibold text-slate-500">
      Page 1 of 7 - 74 articles
    </div>

    <!-- Blog Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Blog Card 1 -->
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=600&auto=format&fit=crop" 
                 alt="Wax Therapy" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-white/95 text-slate-900 font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Physiotherapy
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
              Wax Therapy
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">November 15, 2025</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Get wax therapy at home to relieve joint pain, stiffness, and improve mobility. Safe, hygienic sessions by certified physiotherapists.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              Paraffin wax treatment uses warm thermal therapy to deeply penetrate muscles, soothe arthritis symptoms, and restore hand and foot joint range of motion.
            </p>
          </details>
        </div>
      </div>

      <!-- Blog Card 2 -->
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=600&auto=format&fit=crop" 
                 alt="Post-Fracture Stiffness Rehabilitation" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-white/95 text-slate-900 font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Physiotherapy
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
              Post-Fracture Stiffness Rehabilitation
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">February 24, 2026</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Overcome post-fracture stiffness with proven rehab strategies. Improve mobility, reduce pain, and regain strength through targeted recovery exercises.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              Targeted joint mobilization, progressive resistance routines, and localized heat application ensure full range of motion recovery post-cast removal.
            </p>
          </details>
        </div>
      </div>

      <!-- Blog Card 3 -->
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600&auto=format&fit=crop" 
                 alt="Pre and Postnatal Exercises" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-white/95 text-slate-900 font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Physiotherapy
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
              Pre and Postnatal Exercises
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">February 24, 2026</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Safe and effective pre and postnatal exercises support strength, flexibility, and recovery, helping moms stay active and healthy during pregnancy and beyond.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              Customized pelvic floor strengthening, core stabilization, and low-impact posture adjustments guided by maternal health physiotherapists.
            </p>
          </details>
        </div>
      </div>

      <!-- Blog Card 4 -->
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?q=80&w=600&auto=format&fit=crop" 
                 alt="Understanding Leg Pain" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-white/95 text-slate-900 font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Physiotherapy
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
              Understanding Leg Pain – Causes, Risks, and Recovery
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">January 22, 2026</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Learn about the causes of leg pain and how to treat it effectively. Portea offers personalized home-based care and expert guidance for lasting relief.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              From sciatica to muscle strain, accurate home diagnosis paired with physical therapy helps prevent chronic recurring discomfort.
            </p>
          </details>
        </div>
      </div>

      <!-- Blog Card 5 (Featured Card Highlight) -->
      <div class="bg-white rounded-2xl border-2 border-teal-500 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=600&auto=format&fit=crop" 
                 alt="Life After AVN Surgery" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-teal-700 text-white font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Physiotherapy
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-teal-800 leading-snug font-serif">
              Life After AVN Surgery: Recovery and Rehabilitation
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">November 27, 2024</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Look in-home physiotherapy for avascular necrosis post-surgery recovery. Tailored plans by trained professionals help reduce pain &amp; improve balance.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              Assisted gait training, joint burden reduction exercises, and step-by-step home mobility support for Avascular Necrosis post-op care.
            </p>
          </details>
        </div>
      </div>

      <!-- Blog Card 6 -->
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div>
          <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
            <img src="https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?q=80&w=600&auto=format&fit=crop" 
                 alt="Effect Of Music on Mental Health" class="w-full h-full object-cover" />
            <span class="absolute top-3 left-3 bg-white/95 text-slate-900 font-extrabold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
              Nursing
            </span>
          </div>
          <div class="p-5 space-y-2">
            <h3 class="text-base font-bold text-slate-900 leading-snug font-serif">
              Effect Of Music on Mental Health
            </h3>
            <p class="text-[11px] font-semibold text-slate-400">May 28, 2023</p>
            <p class="text-xs text-slate-600 leading-relaxed">
              Our relationship with music is deeply. Everyone knows the effect of music on mental health is unbelievable.
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <details class="group border-t border-slate-100 pt-3">
            <summary class="flex items-center justify-between cursor-pointer text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors select-none">
              <span>Read Full Details</span>
              <span class="text-sm font-extrabold transition-transform duration-300 group-open:rotate-45">+</span>
            </summary>
            <p class="pt-2 text-[11px] text-slate-500 leading-relaxed">
              Explores how sound frequencies stimulate dopamine production, lower cortisol levels, and support emotional recovery during illness.
            </p>
          </details>
        </div>
      </div>

    </div>

    <!-- Pagination Controls -->
    <div class="flex items-center justify-center gap-2 mt-10 pt-4 text-xs font-bold text-slate-600">
      <button class="px-3 py-1.5 rounded-full border border-slate-200 hover:bg-slate-100 text-slate-400 cursor-not-allowed transition-colors">
        &lt; Previous
      </button>
      <button class="w-8 h-8 rounded-full bg-teal-700 text-white flex items-center justify-center shadow-xs">
        1
      </button>
      <button class="w-8 h-8 rounded-full border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 flex items-center justify-center transition-colors">
        2
      </button>
      <span class="px-1 text-slate-400">...</span>
      <button class="w-8 h-8 rounded-full border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 flex items-center justify-center transition-colors">
        7
      </button>
      <button class="px-3 py-1.5 rounded-full border border-teal-600 text-teal-700 hover:bg-teal-50 flex items-center gap-1 transition-colors">
        Next &gt;
      </button>
    </div>

  </section>


<?php include 'footer.php' ?>


<?php include 'footer.php' ?>
