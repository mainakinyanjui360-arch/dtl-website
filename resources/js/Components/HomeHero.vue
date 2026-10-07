<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ShieldCheck, Server, Monitor, ArrowRight } from 'lucide-vue-next';

const slides = [
  {
    title: "Enterprise ICT Infrastructure & Optical Fibre",
    badge: "Certified Engineering",
    description: "End-to-end network deployment, structured cabling, and high-capacity optical fibre engineered for secure corporate operations.",
    primaryCta: "Request Infrastructure Quote",
    primaryLink: "/contact",
    secondaryCta: "Explore Solutions",
    secondaryLink: "/services",
    icon: Server,
    bgImage: "/images/hero/infrastructure.jpg"
  },
  {
    title: "Commercial Hardware & Workstation Procurement",
    badge: "Direct OEM Sourcing",
    description: "Official enterprise fleet deployments: HP, Dell, and Lenovo business desktops, rackmount servers, and data storage solutions.",
    primaryCta: "Browse Hardware Catalog",
    primaryLink: "/hardware",
    secondaryCta: "Request Volume Pricing",
    secondaryLink: "/contact",
    icon: Monitor,
    bgImage: "/images/hero/workstations3.jpg"
  },
  {
    title: "Intelligent CCTV & Enterprise Physical Security",
    badge: "Surveillance & Access Control",
    description: "Enterprise-grade IP surveillance, biometric access control, and 24/7 monitoring systems safeguarding corporate premises.",
    primaryCta: "Consult a Security Specialist",
    primaryLink: "/contact",
    secondaryCta: "View CCTV Systems",
    secondaryLink: "/hardware",
    icon: ShieldCheck,
    bgImage: "/images/hero/cctv security.png"
  }
];

const currentSlide = ref(0);
let timer = null;

const setSlide = (index) => {
  currentSlide.value = index;
  resetTimer();
};

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const resetTimer = () => {
  if (timer) clearInterval(timer);
  timer = setInterval(nextSlide, 7000);
};

onMounted(() => resetTimer());
onUnmounted(() => { if (timer) clearInterval(timer); });
</script>

<template>
  <section class="relative bg-brand-navy overflow-hidden py-28 lg:py-36 text-white min-h-[640px] flex items-center">
    <!-- Background Image Stack with Balanced Cross-Fade -->
    <div class="absolute inset-0 z-0">
      <div 
        v-for="(slide, index) in slides" 
        :key="index"
        class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
        :class="currentSlide === index ? 'opacity-70' : 'opacity-0'"
      >
        <img 
          :src="slide.bgImage" 
          :alt="slide.title" 
          class="w-full h-full object-cover object-center scale-105 transform transition-transform duration-7000 ease-out"
        />
      </div>

      <!-- Balanced Scrim: Soft overall dark base + gentle gradient for text contrast -->
      <div class="absolute inset-0 bg-brand-navy/40"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/85 via-brand-navy/55 to-brand-navy/20"></div>
    </div>

    <!-- Hero Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
      <div class="max-w-3xl space-y-6">
        <div class="relative min-h-[260px]">
          <transition-group 
            enter-active-class="transition-all duration-700 ease-out" 
            enter-from-class="opacity-0 translate-y-3" 
            enter-to-class="opacity-100 translate-y-0" 
            leave-active-class="transition-all duration-500 ease-in absolute top-0 left-0" 
            leave-from-class="opacity-100" 
            leave-to-class="opacity-0 -translate-y-3"
          >
            <div v-for="(slide, index) in slides" :key="index" v-show="currentSlide === index">
              <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-indigo/60 border border-brand-indigo/80 text-white text-xs font-semibold tracking-wide uppercase mb-4 backdrop-blur-md shadow-sm">
                <component :is="slide.icon" class="w-3.5 h-3.5 text-indigo-200" />
                {{ slide.badge }}
              </div>
              
              <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4 text-white drop-shadow-md">
                {{ slide.title }}
              </h1>
              
              <p class="text-slate-100 text-base sm:text-lg max-w-2xl leading-relaxed drop-shadow-sm font-normal">
                {{ slide.description }}
              </p>

              <!-- Dual Action CTAs -->
              <div class="mt-8 flex flex-wrap gap-4 items-center">
                <Link 
                  :href="slide.primaryLink" 
                  class="bg-brand-indigo hover:bg-brand-hover text-white font-medium px-7 py-3.5 rounded-lg shadow-lg shadow-brand-indigo/35 transition-all flex items-center gap-2"
                >
                  <span>{{ slide.primaryCta }}</span>
                  <ArrowRight class="w-4 h-4" />
                </Link>
                <Link 
                  :href="slide.secondaryLink" 
                  class="bg-slate-900/50 backdrop-blur-md border border-white/30 hover:border-white text-white font-medium px-7 py-3.5 rounded-lg transition-all hover:bg-slate-900/70"
                >
                  {{ slide.secondaryCta }}
                </Link>
              </div>
            </div>
          </transition-group>
        </div>

        <!-- Step Indicators -->
        <div class="flex items-center gap-3 pt-4">
          <button 
            v-for="(_, index) in slides" 
            :key="index" 
            @click="setSlide(index)"
            class="group flex items-center gap-2 text-xs font-mono transition-all"
            :class="currentSlide === index ? 'text-white font-bold' : 'text-slate-300 hover:text-white'"
          >
            <span 
              class="w-12 h-1 rounded transition-all" 
              :class="currentSlide === index ? 'bg-brand-indigo' : 'bg-white/30 group-hover:bg-white/50'"
            ></span>
            <span>0{{ index + 1 }}</span>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>