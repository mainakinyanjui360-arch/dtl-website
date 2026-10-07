<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Plus, X, MessageSquare } from 'lucide-vue-next';
import { ref } from 'vue';

const faqs = [
  {
    category: "Orders & Shipping",
    questions: [
      {
        q: "What is your typical delivery timeframe?",
        a: "For products currently in stock, standard delivery within Nairobi takes 1-2 business days. For upcountry deliveries, expect 3-5 business days. Specialized or bulk enterprise orders requiring importation typically take 2-4 weeks. We will provide an exact timeline when generating your quote."
      },
      {
        q: "Do you offer international shipping?",
        a: "Currently, our primary focus is the East African region. We deliver anywhere in Kenya and can arrange specialized shipping to Uganda, Tanzania, and Rwanda upon request."
      },
      {
        q: "Why do some items require a 'Quote Request' instead of direct purchase?",
        a: "Enterprise-grade equipment often requires custom configurations, specialized licensing, or volume pricing. By requesting a quote, our engineers ensure you are getting exactly the right specifications for your infrastructure, and our sales team can often provide better volume discounts."
      }
    ]
  },
  {
    category: "Services & Support",
    questions: [
      {
        q: "Do you provide installation services for the hardware you sell?",
        a: "Yes. We have a dedicated team of certified engineers who can install, configure, and test all network equipment, servers, and security systems we supply. You can select 'Installation Required' when requesting a quote."
      },
      {
        q: "What does your Service Level Agreement (SLA) cover?",
        a: "Our SLAs are customizable but generally cover guaranteed response times (e.g., 4-hour or Next Business Day), preventive maintenance visits, remote support, and hardware replacement for mission-critical infrastructure."
      },
      {
        q: "Do you offer warranties on your products?",
        a: "Absolutely. All our hardware comes with a standard manufacturer's warranty, which typically ranges from 1 to 3 years depending on the brand. We also assist with processing any warranty claims."
      }
    ]
  },
  {
    category: "Payments & Accounts",
    questions: [
      {
        q: "What payment methods do you accept?",
        a: "We accept bank transfers (EFT/RTGS), corporate cheques, and mobile money payments (M-Pesa). For approved corporate accounts, we offer LPO-based credit terms."
      },
      {
        q: "How do I apply for a corporate credit account?",
        a: "Corporate clients can apply for 30-day credit terms by contacting our sales team. You will need to provide your company registration documents, tax compliance certificate, and trade references."
      }
    ]
  }
];

const activeIndex = ref(null);

const toggleFaq = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};
</script>

<template>
  <Head title="Frequently Asked Questions - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- 1. Hero with Breadcrumb & Corporate Backdrop -->
    <section class="relative bg-brand-navy text-white py-20 lg:py-28 overflow-hidden">
      <!-- Background Image with Calibrated Contrast -->
      <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/80 to-brand-navy/40"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium mb-4">
          <Link href="/" class="hover:text-white transition">Home</Link>
          <span class="text-slate-500">/</span>
          <span class="text-indigo-300 font-semibold">FAQs</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          Help Center
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Frequently Asked Questions
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          Find answers to common questions about our enterprise IT solutions, procurement processes, and support services.
        </p>
      </div>
    </section>

    <!-- FAQ Content -->
    <div class="bg-slate-50 py-16 sm:py-24">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div v-for="(section, sIndex) in faqs" :key="sIndex" class="mb-16">
          <h2 class="text-2xl font-bold text-brand-navy mb-6">{{ section.category }}</h2>
          
          <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
            <div 
              v-for="(item, qIndex) in section.questions" 
              :key="qIndex"
              class="py-4 sm:py-6"
            >
              <button 
                @click="toggleFaq(`${sIndex}-${qIndex}`)"
                class="w-full flex items-center justify-between text-left focus:outline-none group px-2"
              >
                <span class="text-base font-medium text-slate-800 pr-4 group-hover:text-brand-indigo transition-colors">{{ item.q }}</span>
                <div class="text-slate-400 shrink-0 ml-4 transition-transform duration-300 group-hover:text-brand-indigo">
                  <X v-if="activeIndex === `${sIndex}-${qIndex}`" class="w-5 h-5" />
                  <Plus v-else class="w-5 h-5" />
                </div>
              </button>
              
              <transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 translate-y-[-10px]"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-[-10px]"
              >
                <div 
                  v-show="activeIndex === `${sIndex}-${qIndex}`"
                  class="pt-4 pb-2 px-2 text-slate-600 leading-relaxed text-sm sm:text-base"
                >
                  {{ item.a }}
                </div>
              </transition>
            </div>
          </div>
        </div>

        <!-- Contact CTA -->
        <div class="mt-16 bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-sm">
          <div class="w-16 h-16 bg-brand-indigo/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <MessageSquare class="w-8 h-8 text-brand-indigo" />
          </div>
          <h3 class="text-xl font-bold text-brand-navy mb-2">Still have questions?</h3>
          <p class="text-slate-500 mb-6">Our enterprise support team is ready to help you with any specific technical or procurement inquiries.</p>
          <Link href="/contact" class="inline-flex items-center justify-center bg-brand-indigo hover:bg-brand-hover text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md shadow-brand-indigo/30">
            Contact Us
          </Link>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>
