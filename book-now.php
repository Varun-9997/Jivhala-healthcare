<?php 
  $pageTitle = "Book Now - Jivhala Healthcare Services";
  include 'header.php'; 
?>

<!-- ===== BOOKING PAGE HERO ===== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
    
    <!-- LEFT: Decorative Illustration & Promise -->
    <div class="hidden lg:block relative">
      <div class="bg-teal-50/60 rounded-3xl p-8 border border-teal-100/60 shadow-sm">
        <div class="aspect-[4/3] bg-gradient-to-br from-teal-100/40 to-emerald-50/60 rounded-2xl flex items-center justify-center p-6 text-center">
          <div>
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-teal-100">
              <span class="text-4xl">💙</span>
            </div>
            <h3 class="text-2xl font-serif font-bold text-teal-900 mt-4 leading-snug">
              Care at home,<br/>the Jivhala way
            </h3>
            <p class="text-sm text-slate-600 mt-3 max-w-xs mx-auto leading-relaxed">
              Professional, verified, and compassionate medical services delivered directly to your doorstep.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Multi-Step Booking Form -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-200/70 p-6 sm:p-8 w-full">
      <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-serif font-extrabold text-slate-900">Book Jivhala Healthcare Services</h1>
        <p class="text-sm text-slate-500 mt-1.5">Please enter your details and our care coordinator will reach out immediately.</p>
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
          <span class="step-label text-xs font-semibold text-slate-500 transition-all duration-300" data-step="2">Schedule</span>
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
              <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Patient / Guardian Name</label>
              <input type="text" id="name" name="name" placeholder="Enter full name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none" required />
            </div>
            <div>
              <label for="mobile" class="block text-sm font-semibold text-slate-700 mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
              <input type="tel" id="mobile" name="mobile" placeholder="+91 xxxxx xxxxx" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none" required />
            </div>
            <div>
              <label for="city" class="block text-sm font-semibold text-slate-700 mb-1.5">City of Service <span class="text-red-500">*</span></label>
              <select id="city" name="city" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none appearance-none" required>
                <option value="">Select your city...</option>
                <option value="chandrapur">Chandrapur</option>
                <option value="nagpur">Nagpur</option>
                <option value="pune">Pune</option>
                <option value="mumbai">Mumbai</option>
                <option value="hyderabad">Hyderabad</option>
                <option value="bhopal">Bhopal</option>
                <option value="bilaspur">Bilaspur</option>
                <option value="gondia">Gondia</option>
                <option value="other">Other Region</option>
              </select>
            </div>
          </div>
        </div>

        <!-- STEP 2: Date & Time -->
        <div class="form-step hidden" data-step="2">
          <div class="space-y-4">
            <div>
              <label for="date" class="block text-sm font-semibold text-slate-700 mb-1.5">Preferred Start Date</label>
              <input type="date" id="date" name="date" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none" required />
            </div>
            <div>
              <label for="time" class="block text-sm font-semibold text-slate-700 mb-1.5">Preferred Shift / Time</label>
              <select id="time" name="time" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none appearance-none" required>
                <option value="">Select shift requirement...</option>
                <option value="12-hour-day">12 Hour Day Shift</option>
                <option value="12-hour-night">12 Hour Night Shift</option>
                <option value="24-hour">24 Hour Live-in Support</option>
                <option value="one-time-visit">One-Time Clinical Visit</option>
              </select>
            </div>
          </div>
        </div>

        <!-- STEP 3: Service Details -->
        <div class="form-step hidden" data-step="3">
          <div class="space-y-4">
            <div>
              <label for="service" class="block text-sm font-semibold text-slate-700 mb-1.5">Service Required <span class="text-red-500">*</span></label>
              <select id="service" name="service" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none appearance-none" required>
                <option value="">Select a core service...</option>
                <option value="patient-care">Patient Care / Attendant</option>
                <option value="elder-care">Elder Care &amp; Companionship</option>
                <option value="nursing">Home Nursing (GNM/ANM)</option>
                <option value="baby-care">Baby Care &amp; Japa Maid</option>
                <option value="physiotherapy">Physiotherapy &amp; Rehab</option>
                <option value="equipment">Medical Equipment Rental/Sales</option>
                <option value="hospital-staffing">Hospital Manpower Staffing</option>
                <option value="doctor-visit">Doctor Home Visit</option>
              </select>
            </div>
            <div>
              <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Patient Condition / Notes (Optional)</label>
              <textarea id="notes" name="notes" rows="3" placeholder="Briefly describe the patient's condition or specific requirements..." class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 outline-none resize-none"></textarea>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between gap-4 pt-6 border-t border-slate-100">
          <button type="button" id="prevBtn" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors disabled:opacity-40 disabled:pointer-events-none">
            Back
          </button>
          <div class="flex gap-3">
            <button type="button" id="nextBtn" class="bg-teal-700 hover:bg-teal-800 text-white font-bold text-sm px-8 py-2.5 rounded-xl transition-all shadow-sm active:scale-95">
              Next Step
            </button>
            <button type="submit" id="submitBtn" class="bg-teal-700 hover:bg-teal-800 text-white font-bold text-sm px-8 py-2.5 rounded-xl transition-all shadow-md active:scale-95 hidden">
              Submit Request
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- ===== SCRIPTS ===== -->
<script>
  // ----- Mobile menu toggle + scroll lock -----
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
      if(!menu) return;
      const isOpen = !menu.classList.contains('hidden');
      const willOpen = (forceClose === undefined) ? !isOpen : !forceClose;

      if (willOpen) {
        menu.classList.remove('hidden');
        if(openIcon) openIcon.classList.add('hidden');
        if(closeIcon) closeIcon.classList.remove('hidden');
        lockScroll();
      } else {
        menu.classList.add('hidden');
        if(openIcon) openIcon.classList.remove('hidden');
        if(closeIcon) closeIcon.classList.add('hidden');
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

  // ----- Multi-step form logic & AJAX Submission -----
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
      // Hide all steps, then show current
      steps.forEach((el, idx) => {
        if (idx + 1 === step) {
          el.classList.remove('hidden');
          el.classList.add('active');
        } else {
          el.classList.add('hidden');
          el.classList.remove('active');
        }
      });

      // Update dots and labels
      dots.forEach((dot, idx) => {
        const num = idx + 1;
        dot.classList.remove('active', 'completed', 'bg-teal-600', 'text-white', 'border-teal-600');
        
        if (num === step) {
          dot.classList.add('active', 'border-teal-600', 'text-teal-700');
        } else if (num < step) {
          dot.classList.add('completed', 'bg-teal-600', 'text-white', 'border-teal-600');
        }
      });

      labels.forEach((label, idx) => {
        const num = idx + 1;
        label.classList.remove('active', 'completed', 'text-teal-800');
        if (num === step) {
          label.classList.add('active', 'text-teal-800');
        } else if (num < step) {
          label.classList.add('completed');
        }
      });

      lines.forEach((line, idx) => {
        if (step > idx + 1) {
          line.classList.add('bg-teal-600');
          line.classList.remove('bg-slate-200');
        } else {
          line.classList.remove('bg-teal-600');
          line.classList.add('bg-slate-200');
        }
      });

      // Buttons
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

    // Input Validation before Next
    function validateStep(step) {
      const currentFormStep = document.querySelector(`.form-step[data-step="${step}"]`);
      const requiredInputs = currentFormStep.querySelectorAll('input[required], select[required]');
      let isValid = true;

      requiredInputs.forEach(input => {
        if (!input.value.trim()) {
          input.classList.add('border-red-400', 'ring-1', 'ring-red-400');
          isValid = false;
        } else {
          input.classList.remove('border-red-400', 'ring-1', 'ring-red-400');
        }
      });

      return isValid;
    }

    // Remove red borders on typing
    document.querySelectorAll('input, select').forEach(input => {
      input.addEventListener('input', function() {
        this.classList.remove('border-red-400', 'ring-1', 'ring-red-400');
      });
    });

    nextBtn.addEventListener('click', function() {
      if (validateStep(currentStep) && currentStep < totalSteps) {
        goToStep(currentStep + 1);
      }
    });

    prevBtn.addEventListener('click', function() {
      if (currentStep > 1) {
        goToStep(currentStep - 1);
      }
    });

    // AJAX Submission logic
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      if(validateStep(currentStep)) {
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Submitting...';
        submitBtn.disabled = true;

        const formData = new FormData(this);

        fetch('process_booking.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          alert('✅ Booking Request Received! Our Jivhala care coordinator will contact you shortly.');
          goToStep(1);
          this.reset();
        })
        .catch(error => {
          alert('❌ Connection error. Please try again.');
        })
        .finally(() => {
          submitBtn.innerHTML = originalBtnText;
          submitBtn.disabled = false;
        });
      }
    });

    // Auto-select service from URL parameter (e.g. ?service=elder-care)
    const urlParams = new URLSearchParams(window.location.search);
    const requestedService = urlParams.get('service');
    if(requestedService) {
      const serviceSelect = document.getElementById('service');
      if(serviceSelect) serviceSelect.value = requestedService;
    }

    // Init
    goToStep(1);
  })();
</script>

<?php include 'footer.php'; ?>