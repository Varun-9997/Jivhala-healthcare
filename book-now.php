
  <title>Book Now</title>

  
</head>

  <!-- ===== HEADER (identical to previous, with two‑column dropdown + mobile scroll lock) ===== -->
<?php include 'header.php' ?>

  <!-- ===== BOOKING PAGE HERO ===== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
      
      <!-- LEFT: image / illustration (decorative) -->
      <div class="hidden lg:block relative">
        <div class="bg-teal-50/60 rounded-3xl p-8 border border-teal-100/60 shadow-sm">
          <div class="aspect-[4/3] bg-gradient-to-br from-teal-100/40 to-emerald-50/60 rounded-2xl flex items-center justify-center p-6">
            <div class="text-center">
              <svg class="w-32 h-32 text-teal-600/40 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C10.34 2 9 3.34 9 5c0 1.25.77 2.32 1.86 2.76C9.13 9.08 8 11.4 8 14v4h2v16h4V18h2v-4c0-2.6-1.13-4.92-2.86-6.24C14.23 7.32 15 6.25 15 5c0-1.66-1.34-3-3-3zm-1 3c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm1 4c2.21 0 4 1.79 4 4v3H8v-3c0-2.21 1.79-4 4-4z"/>
              </svg>
              <h3 class="text-xl font-playfair text-teal-800 mt-4">Care at home,<br/>the Portea way</h3>
              <p class="text-sm text-slate-500 mt-2 max-w-xs mx-auto">Professional medical services delivered to your doorstep with compassion.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Booking Form -->
      <div class="bg-white rounded-3xl shadow-lg border border-slate-200/70 p-6 sm:p-8 w-full">
        <div class="mb-6">
          <h1 class="text-2xl sm:text-3xl font-playfair font-bold text-slate-800">Book Portea’s Medical Services at Home</h1>
          <p class="text-sm text-slate-500 mt-1.5">Please enter your details and we will reach out to you as soon as we can.</p>
        </div>

        <!-- Step Indicator -->
        <div class="flex items-center justify-between gap-2 mb-8">
          <div class="flex items-center gap-2 flex-1">
            <span class="step-dot w-7 h-7 rounded-full border-2 border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500 transition-all duration-300 active" data-step="1">1</span>
            <span class="step-label text-xs font-semibold text-slate-500 transition-all duration-300 active" data-step="1">Contact</span>
            <div class="step-line h-0.5 flex-1 bg-slate-200 transition-all duration-300"></div>
          </div>
          <div class="flex items-center gap-2 flex-1">
            <span class="step-dot w-7 h-7 rounded-full border-2 border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500 transition-all duration-300" data-step="2">2</span>
            <span class="step-label text-xs font-semibold text-slate-500 transition-all duration-300" data-step="2">Date & Time</span>
            <div class="step-line h-0.5 flex-1 bg-slate-200 transition-all duration-300"></div>
          </div>
          <div class="flex items-center gap-2 flex-1">
            <span class="step-dot w-7 h-7 rounded-full border-2 border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500 transition-all duration-300" data-step="3">3</span>
            <span class="step-label text-xs font-semibold text-slate-500 transition-all duration-300" data-step="3">Service</span>
          </div>
        </div>

        <!-- Form Steps -->
        <form id="bookingForm" class="space-y-6">
          <!-- STEP 1: Contact Details -->
          <div class="form-step active" data-step="1">
            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Name</label>
                <input type="text" id="name" placeholder="Please provide your name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white" />
              </div>
              <div>
                <label for="mobile" class="block text-sm font-semibold text-slate-700 mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                <input type="tel" id="mobile" placeholder="To coordinate with you" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white" />
              </div>
              <div>
                <label for="city" class="block text-sm font-semibold text-slate-700 mb-1.5">City <span class="text-red-500">*</span></label>
                <select id="city" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white appearance-none">
                  <option value="">Service Needed In?</option>
                  <option value="mumbai">Mumbai</option>
                  <option value="delhi">Delhi</option>
                  <option value="bangalore">Bangalore</option>
                  <option value="chennai">Chennai</option>
                  <option value="hyderabad">Hyderabad</option>
                  <option value="pune">Pune</option>
                  <option value="kolkata">Kolkata</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
          </div>

          <!-- STEP 2: Date & Time -->
          <div class="form-step" data-step="2">
            <div class="space-y-4">
              <div>
                <label for="date" class="block text-sm font-semibold text-slate-700 mb-1.5">Preferred Date</label>
                <input type="date" id="date" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white" />
              </div>
              <div>
                <label for="time" class="block text-sm font-semibold text-slate-700 mb-1.5">Preferred Time</label>
                <select id="time" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white appearance-none">
                  <option value="">Select time slot</option>
                  <option value="morning">Morning (8am – 12pm)</option>
                  <option value="afternoon">Afternoon (12pm – 4pm)</option>
                  <option value="evening">Evening (4pm – 8pm)</option>
                </select>
              </div>
            </div>
          </div>

          <!-- STEP 3: Service Details -->
          <div class="form-step" data-step="3">
            <div class="space-y-4">
              <div>
                <label for="service" class="block text-sm font-semibold text-slate-700 mb-1.5">Service Required</label>
                <select id="service" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white appearance-none">
                  <option value="">Select a service</option>
                  <option value="physiotherapy">Physiotherapy</option>
                  <option value="nursing">Nursing</option>
                  <option value="medical-equipment">Medical Equipment</option>
                  <option value="trained-attendants">Trained Attendants</option>
                  <option value="lab-tests">Lab Tests</option>
                  <option value="elder-care">Elder Care</option>
                  <option value="doctor-consultation">Doctor Consultation</option>
                  <option value="mother-baby">Mother & Baby Care</option>
                  <option value="diabetes-care">Diabetes Care</option>
                  <option value="critical-care">Critical Care</option>
                  <option value="covid-care">Covid Care</option>
                  <option value="vaccination">Vaccination</option>
                  <option value="counselling">Counselling</option>
                  <option value="nutrition">Nutrition & Diet Consultation</option>
                </select>
              </div>
              <div>
                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Additional Notes (optional)</label>
                <textarea id="notes" rows="3" placeholder="Any special requests or information..." class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white resize-none"></textarea>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="flex items-center justify-between gap-4 pt-4 border-t border-slate-100">
            <button type="button" id="prevBtn" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors disabled:opacity-40 disabled:pointer-events-none">Back</button>
            <div class="flex gap-3">
              <button type="button" id="nextBtn" class="bg-[#00898a] hover:bg-[#006f70] text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all shadow-sm active:scale-95">Next</button>
              <button type="submit" id="submitBtn" class="bg-[#ff5427] hover:bg-[#e04319] text-white font-bold text-sm px-6 py-2.5 rounded-xl transition-all shadow-sm active:scale-95 hidden">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER / extra spacing ===== -->


  <!-- ===== SCRIPTS ===== -->
  <script>
    // ----- mobile menu toggle + scroll lock (from previous) -----
    (function() {
      const btn = document.getElementById('mobile-menu-btn');
      const menu = document.getElementById('mobile-menu');
      const openIcon = document.getElementById('menu-icon-open');
      const closeIcon = document.getElementById('menu-icon-close');
      const body = document.body;

      function lockScroll() {
        body.classList.add('no-scroll');
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

        document.addEventListener('click', function(e) {
          if (!menu.classList.contains('hidden') && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu(false);
          }
        });

        menu.querySelectorAll('a').forEach(link => {
          link.addEventListener('click', function() {
            if (!menu.classList.contains('hidden')) {
              toggleMenu(false);
            }
          });
        });

        window.addEventListener('resize', function() {
          if (window.innerWidth >= 1024 && !menu.classList.contains('hidden')) {
            toggleMenu(false);
          }
        });
      }
    })();

    // ----- Multi-step form logic -----
    (function() {
      const steps = document.querySelectorAll('.form-step');
      const dots = document.querySelectorAll('.step-dot');
      const labels = document.querySelectorAll('.step-label');
      const lines = document.querySelectorAll('.step-line');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const submitBtn = document.getElementById('submitBtn');
      let currentStep = 1;
      const totalSteps = 3;

      function updateUI(step) {
        // show/hide steps
        steps.forEach((el, idx) => {
          el.classList.toggle('active', idx + 1 === step);
        });

        // update dots, labels, lines
        dots.forEach((dot, idx) => {
          const num = idx + 1;
          dot.classList.remove('active', 'completed');
          if (num === step) dot.classList.add('active');
          else if (num < step) dot.classList.add('completed');
        });

        labels.forEach((label, idx) => {
          const num = idx + 1;
          label.classList.remove('active', 'completed');
          if (num === step) label.classList.add('active');
          else if (num < step) label.classList.add('completed');
        });

        lines.forEach((line, idx) => {
          // line after dot i (0-indexed) connects step i to i+1
          // if current step > idx+1, line is completed
          if (step > idx + 1) {
            line.classList.add('bg-teal-600');
            line.classList.remove('bg-slate-200');
          } else {
            line.classList.remove('bg-teal-600');
            line.classList.add('bg-slate-200');
          }
        });

        // buttons
        if (step === 1) {
          prevBtn.disabled = true;
        } else {
          prevBtn.disabled = false;
        }

        if (step === totalSteps) {
          nextBtn.classList.add('hidden');
          submitBtn.classList.remove('hidden');
        } else {
          nextBtn.classList.remove('hidden');
          submitBtn.classList.add('hidden');
        }
      }

      function goToStep(step) {
        if (step < 1) step = 1;
        if (step > totalSteps) step = totalSteps;
        currentStep = step;
        updateUI(currentStep);
      }

      // next
      nextBtn.addEventListener('click', function() {
        if (currentStep < totalSteps) {
          goToStep(currentStep + 1);
        }
      });

      // prev
      prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
          goToStep(currentStep - 1);
        }
      });

      // submit (demo)
      document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('✅ Booking submitted! (demo) We will reach out to you shortly.');
        // reset to step 1
        goToStep(1);
        // optionally reset fields
        this.reset();
      });

      // init
      goToStep(1);
    })();
  </script>
<?php include 'footer.php' ?>