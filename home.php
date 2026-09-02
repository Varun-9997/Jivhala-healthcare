

    <title>Home </title>


<?php include 'header.php' ?>

<!-- sectioin 1 -->
  <!-- HERO SECTION -->
  <section class="relative min-h-screen flex items-center overflow-hidden py-12 lg:py-20 px-4 sm:px-6 lg:px-12 xl:px-20 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
      
      <!-- LEFT CONTENT COLUMN -->
      <div class="lg:col-span-7 space-y-6 z-10">
        
        <!-- Badge / Subtitle -->
        <div class="opacity-0 animate-fade-up [animation-delay:100ms]">
          <span class="inline-flex items-center gap-2 text-[11px] sm:text-xs font-bold tracking-widest text-[#008080] uppercase">
            India's Home Healthcare Pioneers <span class="text-xs">•</span> Since 2013
          </span>
        </div>

        <!-- Main Heading -->
        <h1 class="opacity-0 animate-fade-up [animation-delay:250ms] font-serif-heading text-3xl sm:text-5xl lg:text-6xl font-bold text-[#1a2d37] leading-[1.15] tracking-tight">
          Quality Medical <br class="hidden sm:inline" />Care in the <br class="hidden sm:inline" />
          <span class="relative inline-block italic font-serif">
            Comfort of Your Home
            <!-- Curved Underline Accent SVG -->
            <svg class="absolute -bottom-2 left-0 w-full h-3 text-[#A6292F]" viewBox="0 0 320 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 14C90 4 230 4 315 14" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
            </svg>
          </span>
        </h1>

        <!-- Subheading Paragraph -->
        <p class="opacity-0 animate-fade-up [animation-delay:400ms] text-slate-600 text-sm sm:text-base lg:text-lg max-w-xl leading-relaxed">
          Doctors, nurses, physiotherapists and trained attendants &ndash; compassionate, expert care delivered to your doorstep.
        </p>

        <!-- Search / Action Bar Box -->
        <div class="opacity-0 animate-fade-up [animation-delay:550ms] pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-4 sm:gap-6">
          
          <!-- Dropdown Card + Button container -->
          <div class="bg-white rounded-full p-2 pl-6 pr-2 shadow-xl shadow-slate-200/60 flex items-center justify-between border border-slate-100 min-w-0 w-full sm:w-auto">
            <div class="flex items-center gap-3 text-slate-700 text-sm font-medium cursor-pointer py-1 pr-4">
              <span class="truncate">What care do you need?</span>
              <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
            
          <a href="book-now.php"
   class="inline-flex items-center justify-center bg-[#A6292F] hover:bg-[#d44819] text-white px-6 py-3 rounded-full text-sm font-bold transition-all duration-200 shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-95 whitespace-nowrap">
    Book Now
    </a>
          </div>

          <!-- Direct Phone Contact -->
          <a href="tel:18001212323" class="flex items-center justify-center sm:justify-start gap-2.5 text-slate-800 font-bold hover:text-[#008080] transition-colors py-2 px-2 group">
            <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-[#008080] group-hover:bg-[#008080] group-hover:text-white transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
              </svg>
            </div>
            <span class="text-sm sm:text-base tracking-wide whitespace-nowrap">1800 121 2323</span>
          </a>

        </div>

      </div>

      <!-- RIGHT IMAGE & FLOATING STAT CARDS COLUMN -->
      <div class="lg:col-span-5 relative mt-8 lg:mt-0 opacity-0 animate-fade-up [animation-delay:350ms]">
        
        <!-- Image Container -->
        <div class="relative w-full h-[380px] sm:h-[480px] lg:h-[520px] rounded-3xl overflow-hidden shadow-2xl shadow-slate-300/40 border-4 border-white">
          <img 
            src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=1200&q=80" 
            alt="Healthcare worker attending patient at home" 
            class="w-full h-full object-cover object-center"
          />
        </div>

        <!-- Floating Card 1: Hospital Partners -->
        <div class="absolute -left-3 sm:-left-8 top-[8%] z-20 bg-white/95 backdrop-blur-md px-5 py-3.5 rounded-2xl shadow-xl shadow-slate-300/50 border border-slate-100 animate-float">
          <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">100+</div>
          <div class="text-[10px] sm:text-xs font-bold text-slate-500 tracking-wider uppercase">Hospital Partners</div>
        </div>

        <!-- Floating Card 2: Patients Served -->
        <div class="absolute -left-6 sm:-left-12 top-[42%] z-20 bg-white/95 backdrop-blur-md px-5 py-3.5 rounded-2xl shadow-xl shadow-slate-300/50 border border-slate-100 animate-float [animation-delay:1.5s]">
          <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">20 Lakh+</div>
          <div class="text-[10px] sm:text-xs font-bold text-slate-500 tracking-wider uppercase">Patients Served</div>
        </div>

        <!-- Floating Card 3: Cities Across India -->
        <div class="absolute left-0 sm:-left-4 bottom-[8%] z-20 bg-white/95 backdrop-blur-md px-5 py-3.5 rounded-2xl shadow-xl shadow-slate-300/50 border border-slate-100 animate-float [animation-delay:0.8s]">
          <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">135</div>
          <div class="text-[10px] sm:text-xs font-bold text-slate-500 tracking-wider uppercase">Cities Across India</div>
        </div>

      </div>

    </div>
  </section>
 <!-- sectioin 2 -->

  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 max-w-7xl mx-auto animate-fade-in">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">What We Do</span>
      <h2 class="font-serif-heading text-2xl sm:text-4xl font-bold text-[#1a2d37] mb-3">
        Medical Services Offered At Home
      </h2>
      <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
        Portea Medical offers a variety of healthcare services in the comfort of our patient's homes including:
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
      
      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Trained Attendants</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Nursing Care</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Physiotherapy</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Medical Equipment</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Critical Care</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Mother & Baby Care</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Elder Care</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Doctor Consultation</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Vaccination</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Counselling</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

      <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate">Diabetes Care</span>
            <span class="text-slate-400 text-xs">→</span>
          </div>
        </div>
        <button class="text-[11px] font-semibold text-teal-800 bg-teal-50/80 hover:bg-teal-100 border border-teal-200/60 px-3 py-1.5 rounded-full transition-colors shrink-0">Book Now</button>
      </div>

    </div>
  </section>

 <!-- sectioin 3 -->

  <section class="bg-[#092B28] text-white py-16 sm:py-20 px-4 sm:px-6 lg:px-12 relative overflow-hidden">
    <div class="max-w-7xl mx-auto relative z-10">
      
      <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
        <span class="text-[11px] font-bold tracking-widest text-teal-300 uppercase block mb-2">A Simple, Guided Process</span>
        <h2 class="font-serif-heading text-2xl sm:text-4xl font-bold text-white">How Portea Works</h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <div class="relative bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 sm:p-7 backdrop-blur-sm flex flex-col justify-between overflow-hidden group hover:border-teal-700/80 transition-colors">
          <span class="absolute right-4 bottom-2 text-7xl font-bold text-teal-800/20 select-none pointer-events-none font-serif">1</span>
          <div>
            <div class="w-10 h-10 rounded-xl bg-teal-900/80 border border-teal-700/50 flex items-center justify-center text-teal-300 mb-6">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <h3 class="text-base font-bold text-white mb-2">Book or call us</h3>
            <p class="text-xs text-teal-100/70 leading-relaxed">
              Tell us the care you need - book online in minutes or speak to a care advisor on 1800 121 2323.
            </p>
          </div>
        </div>

        <div class="relative bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 sm:p-7 backdrop-blur-sm flex flex-col justify-between overflow-hidden group hover:border-teal-700/80 transition-colors">
          <span class="absolute right-4 bottom-2 text-7xl font-bold text-teal-800/20 select-none pointer-events-none font-serif">2</span>
          <div>
            <div class="w-10 h-10 rounded-xl bg-teal-900/80 border border-teal-700/50 flex items-center justify-center text-teal-300 mb-6">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <h3 class="text-base font-bold text-white mb-2">Clinical assessment</h3>
            <p class="text-xs text-teal-100/70 leading-relaxed">
              Our clinical team understands the patient's condition and matches the right professional for it.
            </p>
          </div>
        </div>

        <div class="relative bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 sm:p-7 backdrop-blur-sm flex flex-col justify-between overflow-hidden group hover:border-teal-700/80 transition-colors">
          <span class="absolute right-4 bottom-2 text-7xl font-bold text-teal-800/20 select-none pointer-events-none font-serif">3</span>
          <div>
            <div class="w-10 h-10 rounded-xl bg-teal-900/80 border border-teal-700/50 flex items-center justify-center text-teal-300 mb-6">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h3 class="text-base font-bold text-white mb-2">Care begins at home</h3>
            <p class="text-xs text-teal-100/70 leading-relaxed">
              A background-verified clinician arrives at your doorstep with a personalised care plan.
            </p>
          </div>
        </div>

        <div class="relative bg-teal-950/40 border border-teal-800/50 rounded-2xl p-6 sm:p-7 backdrop-blur-sm flex flex-col justify-between overflow-hidden group hover:border-teal-700/80 transition-colors">
          <span class="absolute right-4 bottom-2 text-7xl font-bold text-teal-800/20 select-none pointer-events-none font-serif">4</span>
          <div>
            <div class="w-10 h-10 rounded-xl bg-teal-900/80 border border-teal-700/50 flex items-center justify-center text-teal-300 mb-6">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h3 class="text-base font-bold text-white mb-2">Ongoing follow-up</h3>
            <p class="text-xs text-teal-100/70 leading-relaxed">
              Regular progress reviews keep the plan on track - and adjust it as recovery advances.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

 <!-- sectioin 4 -->

  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Limited-Time Savings</span>
      <h2 class="font-serif-heading text-2xl sm:text-4xl font-bold text-[#1a2d37]">New Offers</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden grid grid-cols-2 hover:shadow-md transition-shadow">
        <div class="p-5 flex flex-col justify-between bg-[#F7F4EC]">
          <div>
            <span class="inline-block bg-[#008080] text-white text-[10px] font-bold px-2.5 py-1 rounded-full mb-3">
              ₹100 Off
            </span>
            <h3 class="text-sm font-bold text-slate-900 mb-1">Physiotherapy</h3>
            <p class="text-[11px] text-slate-600 leading-snug">
              Flat Rs.100/- Off On Your 1st Physiotherapy Session.
            </p>
          </div>
          <div class="mt-4">
            <button class="bg-[#A6292F] hover:bg-[#d44819] text-white text-[11px] font-bold px-4 py-2 rounded-lg transition-colors mb-1.5 w-full text-center">
              Book Now
            </button>
            <span class="text-[9px] text-slate-400 block">*T&C apply</span>
          </div>
        </div>
        <div class="relative bg-teal-50/50 overflow-hidden min-h-[160px]">
          <img 
            src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=600&q=80" 
            alt="Physiotherapy session" 
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden grid grid-cols-2 hover:shadow-md transition-shadow">
        <div class="p-5 flex flex-col justify-between bg-[#F7F4EC]">
          <div>
            <span class="inline-block bg-[#008080] text-white text-[10px] font-bold px-2.5 py-1 rounded-full mb-3">
              10% Off
            </span>
            <h3 class="text-sm font-bold text-slate-900 mb-1">Eldercare</h3>
            <p class="text-[11px] text-slate-600 leading-snug">
              Get Flat 10% Off Caretaker at Home
            </p>
          </div>
          <div class="mt-4">
            <button class="bg-[#A6292F] hover:bg-[#d44819] text-white text-[11px] font-bold px-4 py-2 rounded-lg transition-colors mb-1.5 w-full text-center">
              Book Now
            </button>
            <span class="text-[9px] text-slate-400 block">*T&C apply</span>
          </div>
        </div>
        <div class="relative bg-teal-50/50 overflow-hidden min-h-[160px]">
          <img 
            src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=600&q=80" 
            alt="Eldercare service" 
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden grid grid-cols-2 hover:shadow-md transition-shadow">
        <div class="p-5 flex flex-col justify-between bg-[#F7F4EC]">
          <div>
            <span class="inline-block bg-[#008080] text-white text-[10px] font-bold px-2.5 py-1 rounded-full mb-3">
              10% Off
            </span>
            <h3 class="text-sm font-bold text-slate-900 mb-1">Doctor Visit</h3>
            <p class="text-[11px] text-slate-600 leading-snug">
              Flat 10% Off On Doctor Visit to your home
            </p>
          </div>
          <div class="mt-4">
            <button class="bg-[#A6292F] hover:bg-[#d44819] text-white text-[11px] font-bold px-4 py-2 rounded-lg transition-colors mb-1.5 w-full text-center">
              Book Now
            </button>
            <span class="text-[9px] text-slate-400 block">*T&C apply</span>
          </div>
        </div>
        <div class="relative bg-teal-50/50 overflow-hidden min-h-[160px]">
          <img 
            src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80" 
            alt="Doctor home visit" 
            class="w-full h-full object-cover"
          />
        </div>
      </div>

    </div>
  </section>






  <!-- ========================================================= -->
  <!-- SECTION 5: STATS & IMPACT BANNER -->
  <!-- ========================================================= -->
  <section class="bg-[#FAF7F2] border-y border-slate-200/60 py-8 sm:py-10 px-4 sm:px-6 lg:px-12 animate-welcome">
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-0 divide-y sm:divide-y-0 lg:divide-x divide-slate-200/80">
        
        <!-- Stat Item 1 -->
        <div class="flex flex-col items-center justify-center text-center p-4">
          <h3 class="text-2xl sm:text-3xl font-extrabold text-[#008080] tracking-tight mb-1">India's Leading</h3>
          <p class="text-[10px] sm:text-xs font-bold text-slate-600 tracking-wider uppercase">Home Healthcare Company</p>
        </div>

        <!-- Stat Item 2 -->
        <div class="flex flex-col items-center justify-center text-center p-4 pt-6 sm:pt-4">
          <h3 class="text-3xl sm:text-4xl font-extrabold text-[#008080] tracking-tight mb-1">100+</h3>
          <p class="text-[10px] sm:text-xs font-bold text-slate-600 tracking-wider uppercase">Top Hospital Partnerships</p>
        </div>

        <!-- Stat Item 3 -->
        <div class="flex flex-col items-center justify-center text-center p-4 pt-6 lg:pt-4">
          <h3 class="text-3xl sm:text-4xl font-extrabold text-[#008080] tracking-tight mb-1">15 Lakh+</h3>
          <p class="text-[10px] sm:text-xs font-bold text-slate-600 tracking-wider uppercase">Annual Patient Visits Across India</p>
        </div>

        <!-- Stat Item 4 -->
        <div class="flex flex-col items-center justify-center text-center p-4 pt-6 lg:pt-4">
          <h3 class="text-3xl sm:text-4xl font-extrabold text-[#008080] tracking-tight mb-1">20 Lakh+</h3>
          <p class="text-[10px] sm:text-xs font-bold text-slate-600 tracking-wider uppercase">Total Patients Served</p>
        </div>

      </div>
    </div>
  </section>


  <!-- ========================================================= -->
  <!-- SECTION 6: HAPPY CUSTOMERS (TESTIMONIALS SLIDER/CAROUSEL) -->
  <!-- ========================================================= -->
  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 bg-white animate-welcome [animation-delay:200ms]">
    <div class="max-w-7xl mx-auto">
      
      <!-- Section Header -->
      <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
        <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37] mb-3">Happy Customers</h2>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
          Don't simply consider our word for it — hear what our customers say about their experience with Portea.
        </p>
      </div>

      <!-- Testimonials Grid Container -->
      <div class="relative">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-stretch">
          
          <!-- Card 1 -->
          <div class="bg-white rounded-2xl border border-teal-500/30 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 relative group">
            <div>
              <span class="text-4xl font-serif text-teal-200 block mb-2 leading-none">“</span>
              <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed mb-4">
                Counsellor Mary Fathima's explanation is excellent and the information shared is very useful, as most people do not know the test procedure (i.e. test timings and the difference) of the FBS, PPBS and RBS tests even though they are literate. I was also...
              </p>
              <a href="#" class="text-xs font-bold text-[#008080] underline hover:text-teal-800 transition-colors inline-block mb-6">Read more</a>
            </div>
            
            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-200 text-[#008080] font-bold text-sm flex items-center justify-center shrink-0">
                S
              </div>
              <div class="min-w-0">
                <h4 class="text-xs font-bold text-slate-800 truncate">Shama Sunder</h4>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 relative group">
            <div>
              <span class="text-4xl font-serif text-teal-200 block mb-2 leading-none">“</span>
              <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed mb-4">
                I have availed Portea Elder care service and would like to sincerely thank Health Manager Saba for being a single point of contact as it has made my life easier and simpler on arranging my appointments on time as required and Portea for giving such a good...
              </p>
              <a href="#" class="text-xs font-bold text-[#008080] underline hover:text-teal-800 transition-colors inline-block mb-6">Read more</a>
            </div>
            
            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-200 text-[#008080] font-bold text-sm flex items-center justify-center shrink-0">
                Z
              </div>
              <div class="min-w-0">
                <h4 class="text-xs font-bold text-slate-800 truncate">Zaka Nasir Shaikh</h4>
                <p class="text-[11px] text-slate-400">Kolkata</p>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 relative group">
            <div>
              <span class="text-4xl font-serif text-teal-200 block mb-2 leading-none">“</span>
              <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed mb-4">
                Thank you for the gift given to us on your Customer Day celebration. We would like to record our appreciation for the services rendered by your staff Coordinator Ms Yasodha, Patient attendees Mr. Murugesan, have been very attentive to our needs and thanks for the services.
              </p>
            </div>
            
            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-200 text-[#008080] font-bold text-sm flex items-center justify-center shrink-0">
                T
              </div>
              <div class="min-w-0">
                <h4 class="text-xs font-bold text-slate-800 truncate">T.E.Degaleesan</h4>
              </div>
            </div>
          </div>

          <!-- Card 4 (Partial/Visible on larger screens) -->
          <div class="hidden lg:flex bg-white rounded-2xl border border-slate-200 p-6 flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 relative group opacity-60 hover:opacity-100">
            <div>
              <span class="text-4xl font-serif text-teal-200 block mb-2 leading-none">“</span>
              <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed mb-4">
                I am utterly pleased with the care session provided for my father. Chandrashekar was punctual and impressed us with his professional skill. His attitude was extremely patient and supportive throughout...
              </p>
            </div>
            
            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-200 text-[#008080] font-bold text-sm flex items-center justify-center shrink-0">
                H
              </div>
              <div class="min-w-0">
                <h4 class="text-xs font-bold text-slate-800 truncate">Harish V.</h4>
              </div>
            </div>
          </div>

        </div>

        <!-- Carousel Next Button -->
        <button aria-label="Next testimonials" class="hidden sm:flex absolute -right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#008080] hover:border-[#008080] shadow-md items-center justify-center transition-all z-10">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>
      </div>

    </div>
  </section>


  <!-- ========================================================= -->
  <!-- SECTION 7: EXPERT DOCTOR PANEL (CLINICAL LEADERSHIP) -->
  <!-- ========================================================= -->
  <section class="bg-[#FAF7F2] py-16 sm:py-20 px-4 sm:px-6 lg:px-12 animate-welcome [animation-delay:400ms]">
    <div class="max-w-7xl mx-auto text-center">
      
      <!-- Section Sub-Header & Title -->
      <div class="max-w-2xl mx-auto mb-12 sm:mb-14">
        <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Clinical Leadership</span>
        <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37]">Our Expert Doctor Panel</h2>
      </div>

      <!-- Doctor Cards Container -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">
        
        <!-- Doctor Card 1 -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center text-center">
          <!-- Circular Doctor Avatar -->
          <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden mb-5 border-2 border-teal-100 shadow-inner">
            <img 
              src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80" 
              alt="Dr. Kavitha S Manjunath" 
              class="w-full h-full object-cover"
            />
          </div>

          <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">Dr. Kavitha S Manjunath</h3>
          <span class="text-[11px] font-bold tracking-wider text-[#008080] uppercase block mb-4 max-w-xs leading-snug">
            Clinical Head – Primary, Preventive & Elderly Care
          </span>

          <p class="text-xs text-slate-500 leading-relaxed mb-6 flex-grow">
            Dr Kavitha Manjunath has over 17 years of experience in management of infectious diseases, chronic diseases, palliative care, elderly care besides home healthcare. She is a member of the Family Physician Association.
          </p>

          <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080] hover:text-teal-800 transition-colors">
            Know More <span class="text-sm">→</span>
          </a>
        </div>

        <!-- Doctor Card 2 -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center text-center">
          <!-- Circular Doctor Avatar -->
          <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden mb-5 border-2 border-teal-100 shadow-inner">
            <img 
              src="https://images.unsplash.com/photo-1594824813566-78a9027a1414?auto=format&fit=crop&w=400&q=80" 
              alt="Dr Allia Rahaman" 
              class="w-full h-full object-cover"
            />
          </div>

          <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">Dr Allia Rahaman</h3>
          <span class="text-[11px] font-bold tracking-wider text-[#008080] uppercase block mb-4 leading-snug">
            Clinical Head
          </span>

          <p class="text-xs text-slate-500 leading-relaxed mb-6 flex-grow">
            Dr. Allia Rahaman has over 11 years of experience in the management of chronic disease, emergency medicine, and critical care. She has certification in Diabetes Management from BMJ Fortis along with a certification in ACL...
          </p>

          <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080] hover:text-teal-800 transition-colors">
            Know More <span class="text-sm">→</span>
          </a>
        </div>

      </div>

      <!-- Bottom Action Button -->
      <div>
        <a href="#" class="inline-flex items-center gap-2 border-2 border-[#008080] text-[#008080] hover:bg-[#008080] hover:text-white px-7 py-2.5 rounded-full text-xs font-bold transition-all duration-200 shadow-sm">
          More about our clinical team <span class="text-sm">→</span>
        </a>
      </div>

    </div>
  </section>








  <!-- ========================================================= -->
  <!-- SECTION 8: CASE STUDIES (CAROUSEL / GRID) -->
  <!-- ========================================================= -->
  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 max-w-7xl mx-auto animate-welcome">
    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Real Recoveries</span>
      <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37]">Case Studies</h2>
    </div>

    <!-- Cards Slider Container -->
    <div class="relative">
      
      <!-- Left Navigation Arrow -->
      <button aria-label="Previous case study" class="hidden sm:flex absolute -left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#008080] hover:border-[#008080] shadow-md items-center justify-center transition-all z-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>

      <!-- Right Navigation Arrow -->
      <button aria-label="Next case study" class="hidden sm:flex absolute -right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#008080] hover:border-[#008080] shadow-md items-center justify-center transition-all z-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-stretch overflow-hidden">
        
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300">
          <div>
            <!-- Badge & Meta info -->
            <div class="flex items-center gap-2 mb-4 flex-wrap">
              <span class="bg-teal-50 text-[#008080] text-[10px] font-extrabold px-2.5 py-1 rounded-md tracking-wider uppercase">
                Critical Care
              </span>
              <span class="text-[11px] font-medium text-slate-400">June 2021 • Bengaluru</span>
            </div>
            
            <h3 class="text-sm font-bold text-slate-900 leading-snug mb-3 hover:text-[#008080] transition-colors cursor-pointer">
              ICU Setup At Home With Efficient Nursing And Supportive Care
            </h3>
            
            <p class="text-xs text-slate-500 leading-relaxed mb-6 line-clamp-4">
              This 77 year old, female patient was diagnosed of having pneumonia with recurrent urosepsis was admitted in this multi-specialty hospital in Bengaluru. Post med...
            </p>
          </div>

          <div>
            <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080] hover:text-teal-800 transition-colors">
              Read story <span class="text-sm">→</span>
            </a>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300">
          <div>
            <div class="flex items-center gap-2 mb-4 flex-wrap">
              <span class="bg-teal-50 text-[#008080] text-[10px] font-extrabold px-2.5 py-1 rounded-md tracking-wider uppercase">
                Critical Care
              </span>
              <span class="text-[11px] font-medium text-slate-400">May 2021 • Bengaluru</span>
            </div>

            <h3 class="text-sm font-bold text-slate-900 leading-snug mb-3 hover:text-[#008080] transition-colors cursor-pointer">
              Having Viral Pneumonia with Severe ARDS, CKD
            </h3>

            <p class="text-xs text-slate-500 leading-relaxed mb-6 line-clamp-4">
              This 63 year old, male patient was diagnosed of having viral pneumonia with severe ARDS (Acute respiratory distress syndrome), CKD (Chronic kidney disease) and _
            </p>
          </div>

          <div>
            <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080] hover:text-teal-800 transition-colors">
              Read story <span class="text-sm">→</span>
            </a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300">
          <div>
            <div class="flex items-center gap-2 mb-4 flex-wrap">
              <span class="bg-teal-50 text-[#008080] text-[10px] font-extrabold px-2.5 py-1 rounded-md tracking-wider uppercase">
                Critical Care
              </span>
              <span class="text-[11px] font-medium text-slate-400">Jan 2020 • Mumbai</span>
            </div>

            <h3 class="text-sm font-bold text-slate-900 leading-snug mb-3 hover:text-[#008080] transition-colors cursor-pointer">
              Seizures Leading to Neurological Issues
            </h3>

            <p class="text-xs text-slate-500 leading-relaxed mb-6 line-clamp-4">
              This 85 year old, male patient had a fall, followed by seizures leading to neurological issues resulting in critical illness and on oxygen support. Post medical...
            </p>
          </div>

          <div>
            <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080] hover:text-teal-800 transition-colors">
              Read story <span class="text-sm">→</span>
            </a>
          </div>
        </div>

        <!-- Card 4 (Partial/Overflow view for slider feel) -->
        <div class="hidden lg:flex bg-white rounded-2xl border border-slate-200/90 p-6 flex-col justify-between shadow-sm opacity-60 hover:opacity-100 transition-all duration-300">
          <div>
            <div class="flex items-center gap-2 mb-4 flex-wrap">
              <span class="bg-teal-50 text-[#008080] text-[10px] font-extrabold px-2.5 py-1 rounded-md tracking-wider uppercase">
                Physiotherapy
              </span>
            </div>

            <h3 class="text-sm font-bold text-slate-900 leading-snug mb-3">
              Diagnosed with Pulmonary Fibrosis
            </h3>

            <p class="text-xs text-slate-500 leading-relaxed mb-6 line-clamp-4">
              This patient diagnosed with Chronic Obstructive Respiratory Disease (COPD) and pulmonary...
            </p>
          </div>

          <div>
            <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#008080]">
              Read story <span class="text-sm">→</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ========================================================= -->
  <!-- SECTION 9: OUR PARTNERS (TRUSTED BY LEADING HOSPITALS) -->
  <!-- ========================================================= -->
  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 bg-white border-t border-slate-100 animate-welcome [animation-delay:200ms]">
    <div class="max-w-7xl mx-auto text-center">
      
      <!-- Section Header -->
      <div class="max-w-3xl mx-auto mb-12">
        <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Trusted by Leading Hospitals</span>
        <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37] mb-4">Our Partners</h2>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-2xl mx-auto">
          Portea works with leading hospitals, experienced doctors, nurses, diagnostic centers, and others to improve health outcomes for patients and profitability for our partners.
        </p>
      </div>

      <!-- Hospital Logo Grid -->
      <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-12 lg:gap-14 mb-10 max-w-5xl mx-auto px-4">
        
        <!-- Logo 1: Fortis -->
        <div class="flex items-center gap-1.5 text-[#2E7D32] font-black text-lg sm:text-xl tracking-tight grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <svg class="w-7 h-7 fill-current text-[#C62828]" viewBox="0 0 24 24">
            <path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"/>
          </svg>
          <span>Fortis<span class="text-xs font-semibold block text-slate-400 uppercase tracking-widest text-left -mt-1">Hospitals</span></span>
        </div>

        <!-- Logo 2: MGM Healthcare -->
        <div class="flex flex-col items-center grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <span class="text-lg sm:text-2xl font-black text-amber-500 tracking-tighter leading-none">MGM</span>
          <span class="text-[9px] font-bold text-slate-700 uppercase tracking-widest">Healthcare</span>
        </div>

        <!-- Logo 3: Sakra -->
        <div class="flex items-center gap-1 text-[#4A148C] font-black text-lg sm:text-xl grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <span class="text-emerald-500 text-2xl font-serif">❖</span>
          <span>SAKRA<span class="text-[8px] font-bold block text-slate-400 uppercase tracking-widest -mt-1">World Hospital</span></span>
        </div>

        <!-- Logo 4: S.L. Raheja -->
        <div class="text-left grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <span class="text-xs sm:text-sm font-bold text-slate-800 block leading-tight">S.L. RAHEJA</span>
          <span class="text-[9px] text-teal-700 font-semibold block uppercase tracking-wider">Hospital</span>
        </div>

        <!-- Logo 5: Saifee Hospital -->
        <div class="flex items-center gap-1.5 text-blue-900 font-serif font-bold text-sm sm:text-base grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <div class="w-5 h-5 rounded-full bg-blue-900 text-white text-[10px] flex items-center justify-center font-sans font-extrabold">S</div>
          <span>SAIFEE HOSPITAL</span>
        </div>

        <!-- Logo 6: Rabindranath Tagore -->
        <div class="text-left grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
          <span class="text-xs sm:text-sm font-extrabold text-sky-900 block leading-tight">NH Rabindranath Tagore</span>
          <span class="text-[8px] text-slate-400 block uppercase tracking-wider">International Institute of Cardiac Sciences</span>
        </div>

        <!-- Logo 7: Jaslok Hospital -->
        <div class="w-full flex justify-center mt-2">
          <div class="flex items-center gap-2 text-rose-700 font-bold text-sm sm:text-base grayscale hover:grayscale-0 opacity-80 hover:opacity-100 transition-all cursor-pointer">
            <span class="text-lg">🌸</span>
            <span class="tracking-wider uppercase text-slate-800 font-extrabold">Jaslok Hospital</span>
          </div>
        </div>

      </div>

      <!-- Action Button -->
      <div>
        <a href="#" class="inline-flex items-center gap-2 border-2 border-[#008080] text-[#008080] hover:bg-[#008080] hover:text-white px-7 py-2.5 rounded-full text-xs font-bold transition-all duration-200 shadow-sm">
          Partner with us <span class="text-sm">→</span>
        </a>
      </div>

    </div>
  </section>


  <!-- ========================================================= -->
  <!-- SECTION 10: PRESS & MEDIA COVERAGE -->
  <!-- ========================================================= -->
  <section class="bg-[#FAF7F2] py-16 sm:py-20 px-4 sm:px-6 lg:px-12 animate-welcome [animation-delay:400ms]">
    <div class="max-w-7xl mx-auto text-center">
      
      <!-- Section Header -->
      <div class="max-w-3xl mx-auto mb-10 sm:mb-12">
        <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">In The News</span>
        <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37] mb-4">Press & Media Coverage</h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
          Leading newspapers and magazines like Times of India, Economic Times, The Statesman, Hindu Businessline and more have featured Portea showcasing our approach, effort and impact in the home healthcare sector.
        </p>
      </div>

      <!-- Media Brands Logo Bar -->
      <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 lg:gap-12 mb-10 max-w-4xl mx-auto px-4">
        
        <!-- Media Logo 1: Business Today -->
        <div class="bg-[#1D3557] text-white font-black italic text-xs sm:text-sm px-3 py-1.5 rounded tracking-tighter opacity-80 hover:opacity-100 transition-opacity cursor-pointer">
          business today
        </div>

        <!-- Media Logo 2: Forbes -->
        <div class="font-serif text-xl sm:text-3xl font-bold text-slate-900 tracking-tight opacity-80 hover:opacity-100 transition-opacity cursor-pointer">
          Forbes
        </div>

        <!-- Media Logo 3: Business Standard -->
        <div class="bg-white border border-slate-200 px-3 py-1 rounded text-red-700 font-serif font-bold text-xs sm:text-sm tracking-tight opacity-80 hover:opacity-100 transition-opacity cursor-pointer">
          Business Standard
        </div>

        <!-- Media Logo 4: The Economic Times -->
        <div class="font-serif font-bold text-xs sm:text-sm text-slate-800 tracking-wider uppercase border-y border-slate-300 py-0.5 opacity-80 hover:opacity-100 transition-opacity cursor-pointer">
          <span class="text-red-700 font-sans font-black mr-1">ET</span> The Economic Times
        </div>

        <!-- Media Logo 5: The Hindu -->
        <div class="font-serif font-bold text-sm sm:text-lg text-slate-900 tracking-widest uppercase opacity-80 hover:opacity-100 transition-opacity cursor-pointer">
          THE HINDU
        </div>

      </div>

      <!-- Action Button -->
      <div>
        <a href="#" class="inline-flex items-center gap-2 border-2 border-[#008080] text-[#008080] hover:bg-[#008080] hover:text-white px-7 py-2.5 rounded-full text-xs font-bold transition-all duration-200 shadow-sm">
          All press coverage <span class="text-sm">→</span>
        </a>
      </div>

    </div>
  </section>





 <!-- sectioin 11 -->


  <!-- <section class="bg-[#FAF7F2] py-16 sm:py-20 px-4 sm:px-6 lg:px-12 animate-welcome">
    <div class="max-w-7xl mx-auto">
      
      <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
        <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Pan-India Presence</span>
        <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37] mb-3">Care in 135 cities across 18 states</h2>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
          From metros to tier-2 and tier-3 towns, Portea brings quality medical care to your doorstep – nationwide, and growing.
        </p>
      </div>

      <div class="flex items-center justify-center gap-4 sm:gap-6 mb-12">
        <div class="bg-white rounded-2xl px-6 py-3 border border-slate-200/80 shadow-sm text-center">
          <span class="text-xl sm:text-2xl font-extrabold text-[#008080] block">18</span>
          <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">States & Regions</span>
        </div>
        <div class="bg-white rounded-2xl px-6 py-3 border border-slate-200/80 shadow-sm text-center">
          <span class="text-xl sm:text-2xl font-extrabold text-[#008080] block">135</span>
          <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Cities Served</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
        
        <div class="space-y-6">
          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Karnataka</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">15</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Bangalore</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Mysuru</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Mangalore</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Hubli</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Dharwad</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Belagavi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Davanagere</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Tumakuru</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Shivamogga</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Udupi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ballari</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Vijayapura</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kalaburagi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Bidar</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Chitradurga</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Maharashtra</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">15</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Mumbai</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Navi Mumbai</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Thane</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Pune</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Nashik</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Nagpur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Aurangabad</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kolhapur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Solapur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Sangli</span>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Gujarat</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">10</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ahmedabad</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Surat</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Vadodara</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Rajkot</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Bhavnagar</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Jamnagar</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Gandhinagar</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Anand</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Kerala</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">10</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kochi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kozhikode</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Thrissur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Thiruvananthapuram</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kollam</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Uttar Pradesh</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">10</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Lucknow</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kanpur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Agra</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Varanasi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Meerut</span>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Madhya Pradesh</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">8</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Indore</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Bhopal</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Gwalior</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Jabalpur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ujjain</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Telangana & Delhi NCR</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">13</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Hyderabad</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Warangal</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">New Delhi</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Gurugram</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Noida</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ghaziabad</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Punjab</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">6</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Chandigarh</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Mohali</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ludhiana</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Amritsar</span>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">West Bengal</h3>
              <span class="bg-teal-100 text-[#008080] text-[10px] font-bold px-1.5 py-0.5 rounded-full">5</span>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Kolkata</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Howrah</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Durgapur</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Siliguri</span>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between border-b-2 border-[#008080] pb-1.5 mb-3">
              <h3 class="text-xs font-extrabold text-slate-800 tracking-wide uppercase">Other Regions</h3>
            </div>
            <div class="flex flex-wrap gap-1.5">
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Raipur (CG)</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Ranchi (JH)</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Bhubaneswar (OR)</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Dehradun (UK)</span>
              <span class="bg-white border border-slate-200 text-slate-600 text-[11px] font-medium px-2.5 py-1 rounded-full shadow-2xs">Guwahati (AS)</span>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section> -->

 <!-- sectioin 12 -->

  <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-12 bg-white animate-welcome [animation-delay:200ms]">
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <div class="lg:col-span-4">
          <span class="text-[11px] font-bold tracking-widest text-[#008080] uppercase block mb-2">Good to know</span>
          <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold text-[#1a2d37] mb-3">Frequently Asked Questions</h2>
          <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-8">
            Everything families usually ask before bringing care home.
          </p>

          <div class="bg-[#FAF7F2] rounded-2xl p-6 border border-slate-200/60">
            <h4 class="text-sm font-bold text-slate-900 mb-1">Still have questions?</h4>
            <p class="text-xs text-slate-500 mb-4">Talk to a care advisor – we're happy to help.</p>
            <a href="tel:18001212323" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#008080] hover:text-teal-800 transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
              </svg>
              1800 121 2323
            </a>
          </div>
        </div>

        <div class="lg:col-span-8 space-y-3">
          
          <div class="bg-[#FAF7F2] rounded-2xl border border-teal-500/40 p-5 transition-all">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-900">What home healthcare services does Portea offer?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">×</span>
            </button>
            <div class="mt-3 pt-3 border-t border-slate-200/60 text-xs text-slate-600 leading-relaxed">
              Portea offers a wide range of home healthcare services, including physiotherapy at home, nursing care at home, elder care, doctor consultations, lab tests, medical equipment rentals, and trained caregivers. Our services are designed to provide quality medical care in the comfort of your home.
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">How can I book home healthcare services with Portea?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">How quickly can care begin?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">Are Portea's nurses, caregivers, and physiotherapists qualified?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">Are your clinicians background-verified?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">Which cities does Portea operate in?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">How much do home healthcare services cost?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-slate-300 transition-all cursor-pointer">
            <button class="w-full flex items-center justify-between text-left gap-4">
              <span class="text-xs sm:text-sm font-bold text-slate-800">Can Portea provide post-hospitalization care at home?</span>
              <span class="text-[#008080] font-bold text-lg leading-none">+</span>
            </button>
          </div>

        </div>

      </div>
    </div>
  </section>

 <!-- sectioin 13 -->

  <section class="bg-[#0A3638] text-white py-14 sm:py-16 px-4 sm:px-6 lg:px-12 animate-welcome [animation-delay:400ms]">
    <div class="max-w-4xl mx-auto text-center">
      
      <h2 class="font-serif-heading text-3xl sm:text-4xl font-bold mb-3 tracking-tight">
        Ready to bring care home?
      </h2>
      
      <p class="text-xs sm:text-sm text-teal-100/80 max-w-xl mx-auto mb-8 leading-relaxed">
        Talk to a care advisor or book a visit in minutes – we'll take it from there.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
        <a href="#" class="w-full sm:w-auto bg-[#A6292F] hover:bg-[#d44819] text-white font-extrabold text-xs px-8 py-3.5 rounded-xl shadow-lg transition-all duration-200 text-center">
          Book Now
        </a>

        <a href="tel:18001212323" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs font-bold text-white hover:text-teal-200 transition-colors py-3.5 px-4">
          <svg class="w-4 h-4 fill-current text-teal-300" viewBox="0 0 24 24">
            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
          </svg>
          1800 121 2323
        </a>
      </div>

    </div>
  </section>


  <?php include 'footer.php' ?>

