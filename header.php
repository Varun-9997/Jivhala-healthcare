


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Healthcare Hero Section</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

<!-- FontAwesome -->
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">

</head>

<body class="bg-[#FAF7F2] text-slate-800 antialiased selection:bg-teal-100 selection:text-teal-900">


  <!-- header with two‑column dropdown (desktop) + mobile scroll lock -->
  <header class="w-full bg-[#A6292F] border-b border-transparent sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
      
      <!-- Brand Logo -->
     <a href="home.php" class="flex items-center gap-2 sm:gap-3 shrink-0">

    <!-- Logo Image -->
    <img
        src="img/JHCLOGO.jpeg"
        alt="Portea Logo"
        class="w-24 h-20  md:w-20 md:h-20 object-contain flex-shrink-0"
    >

    <!-- Logo Text -->
    <div class="flex flex-col leading-none">
        <h1 class="text-xl  md:text-2xl font-black tracking-wide text-white">
            JIVHALA
        </h1>
        <span class="text-[10px]  md:text-xs font-semibold uppercase tracking-[0.2em] text-slate-100 mt-1">
           HEATHCARE SERVICES
        </span>
    </div>

</a>

      <!-- Desktop Navigation: two‑column dropdown -->
      <nav class="hidden lg:flex items-center gap-8 text-sm font-bold text-slate-800">
        <!-- Our Services with two‑column dropdown -->
        <div class="dropdown-group relative py-2">
          <button class="flex text-white items-center gap-1.5 hover:text-[#00898a] transition-colors focus:outline-none cursor-default">
            <span>Our Services</span>
            <svg class="w-4 h-4 text-teal-600 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <!-- dropdown menu – two columns on desktop -->
          <div class="dropdown-menu absolute top-full left-0 w-[480px] bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50 grid grid-cols-2 gap-0">
            <a href="home-nursing.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Home Nursing</a>
            <a href="patient-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Patient Care</a>
            <a href="elder-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Elder Care</a>
            <a href="mother-baby-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Mother & Baby Care</a>
            <a href="medical-equipment.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Medical Equipment</a>
            <a href="wound-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Wound Care</a>
            <a href="injection-iv-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Injection & IV Care</a>
            <!-- <a href="trained-attendants.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Trained Attendants</a>
            <a href="lab-tests.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Lab Tests</a> -->
            <!-- <a href="physiotherapy.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Physiotherapy</a> -->

            <!-- <a href="doctor-consultations.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Doctor Consultation</a>
            
            <a href="diabetes-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Diabetes Care</a>
            <a href="critical-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Critical Care</a>
            <a href="covid-care.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Covid Care</a>
            <a href="vaccination.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Vaccination</a>
            <a href="counselling.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Counselling</a>
            <a href="nutrition-diet-consultation.php" class="block px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50/70 hover:text-teal-700 transition-colors">Nutrition & Diet Consultation</a> -->
          </div>
        </div>

        <a href="about-us.php" class="hover:text-[#00898a] text-white transition-colors">About Us</a>
        <a href="blog.php" class="hover:text-[#00898a] text-white transition-colors">Blogs</a>
        <a href="contact.php" class="hover:text-[#00898a] text-white transition-colors">Contact Us</a>
      </nav>

      <!-- Desktop Call & Booking -->
      <div class="hidden sm:flex items-center gap-3">
        <div class="flex items-center gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-2xs">
          <div class="flag-india">
            <div class="saffron"></div>
            <div class="white"><div class="chakra"></div></div>
            <div class="green"></div>
          </div>
          <svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <a href="tel:+919860390012" class="text-xs sm:text-sm font-extrabold text-slate-900 tracking-tight hover:text-teal-700 transition-colors">+91 9860390012</a>
        </div>
        <a href="book-now.php" class="bg-[#0F766E] hover:bg-[#0F766E]/80 text-white font-extrabold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-xs transition-all active:scale-95">Book Now</a>
      </div>

      <!-- Mobile Toggle -->
      <button id="mobile-menu-btn" type="button" class="lg:hidden p-2 text-slate-700 hover:text-teal-700 bg-white rounded-xl transition-colors focus:outline-none" aria-label="Toggle Menu">
        <svg id="menu-icon-open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="menu-icon-close" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Mobile menu (single column, accordion) with scroll lock -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-4 shadow-xl">
      <div class="space-y-1 text-sm font-bold text-slate-800">
        <details class="mobile-service-details group">
          <summary class="flex items-center justify-between py-2.5 cursor-pointer text-slate-800 hover:text-teal-700">
            <span>Our Services</span>
            <svg class="chevron-icon w-4 h-4 text-teal-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
          </summary>
          <div class="pl-4 pb-2 space-y-2 text-xs text-slate-600 font-semibold border-l-2 border-teal-500 ml-1 mt-1">
            <a href="home-nursing.php" class="block py-1 hover:text-teal-700 transition-colors">Home Nursing</a>
            <a href="patient-care.php" class="block py-1 hover:text-teal-700 transition-colors">Patient Care</a>
            <a href="elder-care.php" class="block py-1 hover:text-teal-700 transition-colors">Elder Care</a>
            <a href="mother-baby-care.php" class="block py-1 hover:text-teal-700 transition-colors">Mother & Baby Care</a>
            <a href="medical-equipment.php" class="block py-1 hover:text-teal-700 transition-colors">Medical Equipment</a>
            <a href="wound-care.php" class="block py-1 hover:text-teal-700 transition-colors">Wound Care</a>
            <a href="injection-iv-care.php" class="block py-1 hover:text-teal-700 transition-colors">Injection & IV Care</a>
            <!-- <a href="mother-baby-care.php" class="block py-1 hover:text-teal-700 transition-colors">Mother & Baby Care</a>
            <a href="diabetes-care.php" class="block py-1 hover:text-teal-700 transition-colors">Diabetes Care</a>
            <a href="critical-care.php" class="block py-1 hover:text-teal-700 transition-colors">Critical Care</a>
            <a href="covid-care.php" class="block py-1 hover:text-teal-700 transition-colors">Covid Care</a>
            <a href="vaccination.php" class="block py-1 hover:text-teal-700 transition-colors">Vaccination</a>
            <a href="counselling.php" class="block py-1 hover:text-teal-700 transition-colors">Counselling</a>
            <a href="nutrition-diet-consultation.php" class="block py-1 hover:text-teal-700 transition-colors">Nutrition & Diet Consultation</a> -->
          </div>
        </details>
        <a href="about-us.php" class="block py-2.5 hover:text-teal-700 transition-colors">About Us</a>
        <a href="blog.php" class="block py-2.5 hover:text-teal-700 transition-colors">Blogs</a>
        <a href="contact-us.php" class="block py-2.5 hover:text-teal-700 transition-colors">Contact Us</a>
      </div>

      <div class="pt-2 border-t border-slate-100 space-y-3">
        <div class="flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-200/60">
          <div class="flex items-center gap-2">
            <div class="flag-india">
              <div class="saffron"></div>
              <div class="white"><div class="chakra"></div></div>
              <div class="green"></div>
            </div>
            <a href="tel:18001212323" class="text-xs font-extrabold text-slate-900">+1800 121 2323</a>
          </div>
          <span class="text-[10px] bg-teal-100 text-teal-800 font-bold px-2 py-0.5 rounded-full">Toll Free</span>
        </div>
        <a href="book-now.php" class="block text-center bg-[#ff5427] hover:bg-[#e04319] text-white font-extrabold text-sm py-3 rounded-xl shadow-xs transition-all">Book Now</a>
      </div>
    </div>
  </header>

  <!-- mobile toggle + scroll lock script -->
  <script>
    (function() {
      const btn = document.getElementById('mobile-menu-btn');
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-icon-open');
      const closeIcon = document.getElementById('menu-icon-close');
      const body = document.body;

      function lockScroll() {
        body.classList.add('no-scroll');
        // store scroll position to prevent jump
        const scrollY = window.scrollY;
        body.style.top = `-${scrollY}px`;
      }

      function unlockScroll() {
        const scrollY = Math.abs(parseInt(body.style.top || '0', 10));
        body.classList.remove('no-scroll');
        body.style.top = '';
        window.scrollTo(0, scrollY);
      }

      function toggleMenu(forceClose) {
        const isOpen = !menu.classList.contains('hidden');
        const willOpen = (forceClose === undefined) ? !isOpen : !forceClose;

        if (willOpen) {
          menu.classList.remove('hidden');
          openIcon.classList.add('hidden');
          closeIcon.classList.remove('hidden');
          lockScroll();
        } else {
          menu.classList.add('hidden');
          openIcon.classList.remove('hidden');
          closeIcon.classList.add('hidden');
          unlockScroll();
        }
      }

      if (btn && menu) {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          toggleMenu();
        });

        // close menu on outside click (optional)
        document.addEventListener('click', function(e) {
          if (!menu.classList.contains('hidden') && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu(false); // force close
          }
        });

        // close menu when a link is clicked (optional)
        menu.querySelectorAll('a').forEach(link => {
          link.addEventListener('click', function() {
            if (!menu.classList.contains('hidden')) {
              toggleMenu(false);
            }
          });
        });

        // handle resize: if menu is open and window becomes desktop, unlock scroll
        window.addEventListener('resize', function() {
          if (window.innerWidth >= 1024 && !menu.classList.contains('hidden')) {
            toggleMenu(false);
          }
        });
      }
    })();
  </script>

