<script setup>
import { reactive, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Phone, 
  Mail, 
  MapPin, 
  Clock, 
  Send, 
  CheckCircle2, 
  MessageSquare 
} from 'lucide-vue-next';

const form = reactive({
  name: '',
  company: '',
  email: '',
  phone: '',
  department: 'Hardware Procurement',
  message: ''
});

const isSubmitted = ref(false);

const submitContact = () => {
  // Can be plugged into your Laravel Controller action
  isSubmitted.value = true;
};
</script>

<template>
  <Head title="Contact Us - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- Header Banner -->
    <section class="relative bg-brand-navy text-white py-20 lg:py-28 overflow-hidden">
      <!-- Background Image with Calibrated Contrast -->
      <div class="absolute inset-0 z-0">
        <img 
          src="/images/hero/infrastructure.jpg" 
          alt="Contact Dignity Traders" 
          class="w-full h-full object-cover object-center opacity-50"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium mb-4">
          <Link href="/" class="hover:text-white transition">Home</Link>
          <span class="text-slate-500">/</span>
          <span class="text-indigo-300 font-semibold">Contact Us</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          Get In Touch
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Speak With Our Enterprise Technology Desk
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          Whether you need a bulk hardware quote, structured cabling survey, or ongoing SLA support, our team is ready to assist.
        </p>
      </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-20 bg-brand-light">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
          
          <!-- Left Column: Direct Contact Info & Map Details -->
          <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-8 border border-brand-border shadow-xs space-y-6">
              <h3 class="text-lg font-bold text-brand-navy border-b border-slate-100 pb-4">
                Corporate Office
              </h3>

              <div class="space-y-5 text-sm">
                <!-- Location -->
                <div class="flex items-start gap-4">
                  <div class="p-2.5 rounded-xl bg-indigo-50 text-brand-indigo shrink-0">
                    <MapPin class="w-5 h-5" />
                  </div>
                  <div>
                    <strong class="block text-brand-navy font-semibold">Head Office</strong>
                    <span class="text-brand-slate text-xs leading-relaxed">
                      Dignity Traders Limited<br>
                      Muthaiga Square, Ground Floor<br>
                      Nairobi, Kenya
                    </span>
                  </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start gap-4">
                  <div class="p-2.5 rounded-xl bg-indigo-50 text-brand-indigo shrink-0">
                    <Phone class="w-5 h-5" />
                  </div>
                  <div>
                    <strong class="block text-brand-navy font-semibold">Direct Telephone</strong>
                    <a href="tel:+254723788354" class="text-brand-indigo hover:underline text-xs font-medium">
                      +254 723 788354
                    </a>
                  </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4">
                  <div class="p-2.5 rounded-xl bg-indigo-50 text-brand-indigo shrink-0">
                    <Mail class="w-5 h-5" />
                  </div>
                  <div>
                    <strong class="block text-brand-navy font-semibold">Inquiries & Quotations</strong>
                    <a href="mailto:info@dignityafrica.co.ke" class="text-brand-indigo hover:underline text-xs font-medium">
                      info@dignityafrica.co.ke
                    </a>
                  </div>
                </div>

                <!-- Working Hours -->
                <div class="flex items-start gap-4">
                  <div class="p-2.5 rounded-xl bg-indigo-50 text-brand-indigo shrink-0">
                    <Clock class="w-5 h-5" />
                  </div>
                  <div>
                    <strong class="block text-brand-navy font-semibold">Business Hours</strong>
                    <span class="text-brand-slate text-xs">
                      Monday – Friday: 8:00 AM – 5:00 PM<br>
                      Saturday: 9:00 AM – 1:00 PM
                    </span>
                  </div>
                </div>
              </div>

              <!-- Quick WhatsApp Box -->
              <div class="mt-6 pt-6 border-t border-slate-100">
                <a 
                  href="https://wa.me/254723788354" 
                  target="_blank" 
                  class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold transition-all"
                >
                  <MessageSquare class="w-4 h-4 text-emerald-600" />
                  <span>Chat with an Engineer on WhatsApp</span>
                </a>
              </div>
            </div>
          </div>

          <!-- Right Column: Interactive Contact & RFP Form -->
          <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl p-8 sm:p-10 border border-brand-border shadow-xs">
              
              <div v-if="isSubmitted" class="py-12 text-center space-y-4">
                <CheckCircle2 class="w-14 h-14 text-emerald-500 mx-auto" />
                <h3 class="text-2xl font-bold text-brand-navy">Message Received</h3>
                <p class="text-sm text-brand-slate max-w-md mx-auto">
                  Thank you for contacting Dignity Traders Ltd. One of our solution engineers or account managers will reach out to you within one business day.
                </p>
                <button 
                  @click="isSubmitted = false" 
                  class="mt-4 text-xs font-semibold text-brand-indigo hover:underline"
                >
                  Send another message
                </button>
              </div>

              <form v-else @submit.prevent="submitContact" class="space-y-5">
                <div>
                  <h3 class="text-xl font-bold text-brand-navy">Send an Inquiry or RFP</h3>
                  <p class="text-xs text-brand-slate mt-1">
                    Fill out the form below and we will route your request directly to the appropriate technical team.
                  </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Your Full Name *</label>
                    <input 
                      v-model="form.name"
                      type="text" 
                      required 
                      placeholder="e.g. Kelvin Mwangi"
                      class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800"
                    />
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Company / Institution Name</label>
                    <input 
                      v-model="form.company"
                      type="text" 
                      placeholder="e.g. Nairobi Logistics Ltd"
                      class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800"
                    />
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Business Email *</label>
                    <input 
                      v-model="form.email"
                      type="email" 
                      required 
                      placeholder="name@company.co.ke"
                      class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800"
                    />
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                    <input 
                      v-model="form.phone"
                      type="tel" 
                      required 
                      placeholder="+254 700 000 000"
                      class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800"
                    />
                  </div>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-700 mb-1">Area of Interest</label>
                  <select 
                    v-model="form.department"
                    class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800 bg-white"
                  >
                    <option>Hardware Procurement (Laptops, Desktops, Servers)</option>
                    <option>Structured Cabling & Optical Fibre</option>
                    <option>CCTV & Physical Surveillance Systems</option>
                    <option>Cybersecurity & Enterprise Firewalls</option>
                    <option>IP Telephony & PABX Systems</option>
                    <option>Annual SLA Maintenance Contract</option>
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-700 mb-1">Message / Project Requirements *</label>
                  <textarea 
                    v-model="form.message"
                    required 
                    rows="4" 
                    placeholder="Provide details on equipment models, quantities, or scope of works..."
                    class="w-full text-xs rounded-xl border border-slate-200 px-3.5 py-2.5 focus:outline-none focus:border-brand-indigo text-slate-800"
                  ></textarea>
                </div>

                <button 
                  type="submit" 
                  class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md transition-all"
                >
                  <span>Submit Inquiry</span>
                  <Send class="w-3.5 h-3.5" />
                </button>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>
    
    <!-- Map Section -->
    <section class="w-full h-96 relative bg-slate-200">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15955.158140321703!2d36.8182285!3d-1.2687129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1737e40e8a71%3A0xb3fcbc50dcb35bc7!2sMuthaiga%20Square!5e0!3m2!1sen!2ske!4v1700000000000!5m2!1sen!2ske" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade"
        class="absolute inset-0 grayscale contrast-125"
      ></iframe>
    </section>
  </PublicLayout>
</template>