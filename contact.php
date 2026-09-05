
  

    <title>Contact Jivhala Healthcare</title>


<?php include 'header.php' ?>


<!-- ================= CONTACT SECTION: IMAGE + FORM WITH WHATSAPP REDIRECT (ATTRACTIVE) ================= -->
<section class="py-16 sm:py-20 bg-gradient-to-br from-slate-50 via-white to-teal-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="bg-gradient-to-r from-teal-600 to-emerald-500 text-white text-xs px-5 py-1.5 rounded-full uppercase font-bold tracking-wider shadow-lg shadow-teal-500/20 inline-flex items-center gap-2">
                <i class="fa-regular fa-message text-xs"></i> Get In Touch
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 font-serif">
                We'd Love to <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-500">Hear From You</span>
            </h2>
            <p class="text-slate-500 mt-3 max-w-2xl mx-auto text-sm sm:text-base">
                Have questions about our services? Need immediate assistance? Reach out to us — we're here to help, 24/7.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <!-- Left Column: Image with Overlay -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-teal-500/10 h-80 sm:h-96 lg:h-[520px] group">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800&auto=format&fit=crop"
                     alt="Contact Jivhala Healthcare"
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105" />
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/30 to-transparent flex flex-col justify-end p-8">
                    <div class="space-y-2">
                        <span class="inline-block bg-teal-500/20 backdrop-blur-sm text-teal-100 text-[10px] font-bold px-3 py-1 rounded-full border border-teal-400/30 uppercase tracking-wider">
                            <i class="fa-regular fa-clock mr-1"></i> 24/7 Available
                        </span>
                        <h3 class="text-2xl font-bold text-white">Jivhala Healthcare</h3>
                        <p class="text-teal-100/80 text-sm">Your service, our responsibility!</p>
                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="tel:+919860390012" class="flex items-center gap-2 text-sm text-white/90 hover:text-white transition">
                                <span class="w-8 h-8 rounded-full bg-teal-500/30 backdrop-blur-sm flex items-center justify-center"><i class="fa-solid fa-phone text-teal-200 text-xs"></i></span>
                                +91 98603 90012
                            </a>
                            <a href="https://wa.me/919860390012" target="_blank" class="flex items-center gap-2 text-sm text-white/90 hover:text-white transition">
                                <span class="w-8 h-8 rounded-full bg-emerald-500/30 backdrop-blur-sm flex items-center justify-center"><i class="fa-brands fa-whatsapp text-emerald-200 text-xs"></i></span>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Right Column: Contact Form -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 sm:p-10 border border-slate-200/60 shadow-xl shadow-slate-200/50 relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-teal-100/30 to-emerald-100/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-gradient-to-tr from-emerald-100/30 to-teal-100/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-1 h-8 bg-gradient-to-b from-teal-500 to-emerald-500 rounded-full"></div>
                        <h3 class="text-2xl font-bold text-slate-900">Send us a Message</h3>
                    </div>
                    <p class="text-sm text-slate-500 mb-6">We'll respond within 30 minutes during business hours.</p>

                    <form id="contactForm" onsubmit="redirectToWhatsApp(event)" class="space-y-4">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Full Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" id="name" name="name" required
                                       class="w-full pl-11 pr-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all text-sm placeholder:text-slate-400"
                                       placeholder="Enter your full name" />
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Phone Number <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="tel" id="phone" name="phone" required
                                       class="w-full pl-11 pr-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all text-sm placeholder:text-slate-400"
                                       placeholder="Enter your phone number" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Email Address
                            </label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="email" id="email" name="email"
                                       class="w-full pl-11 pr-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all text-sm placeholder:text-slate-400"
                                       placeholder="Enter your email address" />
                            </div>
                        </div>

                        <!-- Service Selection -->
                        <div>
                            <label for="service" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Service Interested In <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fa-regular fa-hand absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <select id="service" name="service" required
                                        class="w-full pl-11 pr-10 py-3.5 bg-slate-50/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all text-sm appearance-none">
                                    <option value="">Select a service...</option>
                                    <option value="Baby Care">Mother & Baby Care</option>
                                    <option value="Patient Care">Patient Care</option>
                                    <option value="Injection & IV Care">Injection & IV Care</option>
                                    <option value="Wound Care">Wound Care</option>
                                    <option value="Elder Care">Elder Care</option>
                                    <option value="Physiotherapy">Physiotherapy</option>
                                    <option value="Equipment Rental">Medical Equipment Rental</option>
                                    <option value="Nursing Care">Nursing Care</option>
                                    <option value="Other">Other</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Message
                            </label>
                            <div class="relative">
                                <i class="fa-regular fa-comment absolute left-4 top-4 text-slate-400 text-sm"></i>
                                <textarea id="message" name="message" rows="3"
                                          class="w-full pl-11 pr-4 py-3.5 bg-slate-50/80 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all text-sm placeholder:text-slate-400 resize-none"
                                          placeholder="Tell us about your requirement..."></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-teal-600 to-emerald-500 hover:from-teal-700 hover:to-emerald-600 text-white font-bold py-4 px-6 rounded-2xl transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3 text-sm shadow-lg shadow-teal-500/25 hover:shadow-teal-500/40">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                            Send via WhatsApp
                            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition"></i>
                        </button>

                        <p class="text-[10px] text-slate-400 text-center mt-3 flex items-center justify-center gap-1">
                            <i class="fa-regular fa-lock"></i> Your information is secure. By submitting, you agree to our privacy policy.
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= ADDITIONAL CONTACT INFO SECTION ================= -->
<section class="py-12 bg-gradient-to-br from-teal-900 via-teal-800 to-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Call Us -->
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/10 hover:bg-white/20 transition-all group text-center">

                <div class="w-16 h-16 rounded-full bg-teal-500/25 backdrop-blur-sm text-teal-200 flex items-center justify-center text-3xl mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-phone"></i>
                </div>

                <h4 class="font-bold text-white text-sm">Call Us</h4>

                <p class="text-sm text-teal-200 font-medium">
                    +91 98603 90012
                </p>

                <p class="text-xs text-teal-300/70">
                    24/7 Support
                </p>
            </div>


            <!-- WhatsApp -->
            <a href="https://wa.me/919860390012"
               target="_blank"
               rel="noopener noreferrer"
               class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/10 hover:bg-white/20 transition-all group text-center block">

                <div class="w-16 h-16 rounded-full bg-emerald-500/25 backdrop-blur-sm text-emerald-300 flex items-center justify-center text-3xl mx-auto mb-3 group-hover:scale-110 transition-transform">

                    <i class="fa-brands fa-whatsapp"></i>

                </div>

                <h4 class="font-bold text-white text-sm">
                    WhatsApp
                </h4>

                <p class="text-sm text-emerald-200 font-medium">
                    +91 98603 90012
                </p>

                <p class="text-xs text-emerald-300/70">
                    Quick Response
                </p>
            </a>


            <!-- Email Us -->
            <a href="mailto:jivhalahealthcare@gmail.com"
               class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/10 hover:bg-white/20 transition-all group text-center block">

                <div class="w-16 h-16 rounded-full bg-blue-500/25 backdrop-blur-sm text-blue-300 flex items-center justify-center text-3xl mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <h4 class="font-bold text-white text-sm">
                    Email Us
                </h4>

                <p class="text-sm text-blue-200 font-medium">
                    jivhalahealthcare@gmail.com
                </p>

                <p class="text-xs text-blue-300/70">
                    We respond within 24 hrs
                </p>
            </a>


            <!-- Visit Us -->
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/10 hover:bg-white/20 transition-all group text-center">

                <div class="w-16 h-16 rounded-full bg-amber-500/25 backdrop-blur-sm text-amber-300 flex items-center justify-center text-3xl mx-auto mb-3 group-hover:scale-110 transition-transform">

                    <i class="fa-solid fa-location-dot"></i>

                </div>

                <h4 class="font-bold text-white text-sm">
                    Visit Us
                </h4>

                <p class="text-sm text-amber-200 font-medium">
                    Datala, Chandrapur
                </p>

                <p class="text-xs text-amber-300/70">
                    MH-442406
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ================= JAVASCRIPT FOR WHATSAPP REDIRECT ================= -->
<script>
    function redirectToWhatsApp(event) {
        event.preventDefault();

        // Get form values
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const service = document.getElementById('service').value;
        const message = document.getElementById('message').value.trim();

        // Validate required fields
        if (!name || !phone || !service) {
            alert('Please fill in all required fields (Name, Phone, and Service).');
            return;
        }

        // WhatsApp number (replace with your actual number)
        const whatsappNumber = '919860390012'; // without + sign, country code included

        // Build the WhatsApp message
        let whatsappMessage = `Hello Jivhala Healthcare!%0A%0A`;
        whatsappMessage += `*New Inquiry from Website*%0A%0A`;
        whatsappMessage += `👤 *Name:* ${encodeURIComponent(name)}%0A`;
        whatsappMessage += `📞 *Phone:* ${encodeURIComponent(phone)}%0A`;
        if (email) {
            whatsappMessage += `✉️ *Email:* ${encodeURIComponent(email)}%0A`;
        }
        whatsappMessage += `📋 *Service:* ${encodeURIComponent(service)}%0A`;
        if (message) {
            whatsappMessage += `💬 *Message:* ${encodeURIComponent(message)}%0A`;
        }
        whatsappMessage += `%0AThank you! 🙏`;

        // Create WhatsApp URL
        const whatsappURL = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;

        // Open WhatsApp in new tab
        window.open(whatsappURL, '_blank');
    }
</script>



<?php include 'footer.php' ?>
