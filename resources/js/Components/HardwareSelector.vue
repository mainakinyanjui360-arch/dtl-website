<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const hardwareCategories = [
  {
    id: 'workstations',
    title: 'Desktops & Workstations',
    tagline: 'Reliable. High Performance. Office-Ready.',
    description: 'Commercial HP, Dell, and Lenovo systems engineered for enterprise administrative and engineering performance.',
    image: '/images/hardware/desktops.jpg',
    brands: ['Dell', 'HP', 'Lenovo']
  },
  {
    id: 'servers',
    title: 'Servers & Data Infrastructure',
    tagline: 'High-Uptime. Redundant. Enterprise-Grade.',
    description: 'Rackmount and tower server architectures, NAS storage systems, and enterprise data virtualization appliances.',
    image: '/images/hardware/servers.jpg',
    brands: ['Dell PowerEdge', 'HP ProLiant']
  },
  {
    id: 'cctv',
    title: 'CCTV & Surveillance Hardware',
    tagline: 'Smart Detection. 24/7 Monitoring. High-Res.',
    description: 'Hikvision IP cameras, network video recorders (NVRs), PTZ units, and biometric access control turnstiles.',
    image: '/images/hardware/cctvsec.jpg',
    brands: ['Hikvision']
  },
  {
    id: 'networking',
    title: 'Networking & Fiber Optics',
    tagline: 'High-Throughput. Managed. Resilient.',
    description: 'Managed PoE switches, enterprise firewalls, core routers, fiber patch panels, and Dignity optical cables.',
    image: '/images/hardware/fiber.jpg',
    brands: ['Cisco', 'Fortinet', 'Dignity Fibre']
  },
  {
    id: 'Cybersecurity',
    title: 'Cybersecurity Solutions',
    tagline: 'Advanced Threat Protection. Zero Trust.',
    description: 'Next-generation firewalls, intrusion detection systems, and endpoint security platforms.',
    image: '/images/hardware/cybersecurity.jpg',
    brands: ['Fortinet', 'Cisco', 'Dell']
  }
];

// Carousel slide state (showing 3 cards on desktop)
// Maximum starting index is total items (5) minus visible items (3) = 2
const currentIndex = ref(0);
const maxIndex = hardwareCategories.length - 3;

const prevSlide = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--;
  }
};

const nextSlide = () => {
  if (currentIndex.value < maxIndex) {
    currentIndex.value++;
  }
};

const goToSlide = (index) => {
  currentIndex.value = index;
};
</script>

<template>
  <section class="py-24 bg-brand-light relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header with Carousel Navigation Arrows -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 border-b border-brand-border pb-6">
        <div>
          <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Procurement & Distribution</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
            Enterprise Hardware & Equipment
          </h2>
          <p class="text-brand-slate text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
            Directly sourced from authorized global OEMs. Backed by local replacement warranties and verified commercial reliability across Kenya.
          </p>
        </div>

        <!-- Carousel Slide Controls -->
        <div class="mt-6 md:mt-0 flex items-center gap-3">
          <button 
            @click="prevSlide" 
            :disabled="currentIndex === 0"
            aria-label="Previous Slide"
            class="p-2.5 rounded-xl border border-brand-border bg-white text-brand-navy transition-all shadow-xs disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-50 hover:border-slate-300"
          >
            <ChevronLeft class="w-5 h-5" />
          </button>
          <button 
            @click="nextSlide" 
            :disabled="currentIndex >= maxIndex"
            aria-label="Next Slide"
            class="p-2.5 rounded-xl border border-brand-border bg-white text-brand-navy transition-all shadow-xs disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-50 hover:border-slate-300"
          >
            <ChevronRight class="w-5 h-5" />
          </button>
        </div>
      </div>

      <!-- Carousel Viewport Window -->
      <div class="relative overflow-hidden">
        <!-- Moving Track -->
        <div 
          class="flex transition-transform duration-500 ease-out -mx-3"
          :style="{ transform: `translateX(-${currentIndex * (100 / 3)}%)` }"
        >
          <!-- Individual Card Column (33.333% width each on desktop) -->
          <div 
            v-for="item in hardwareCategories" 
            :key="item.id"
            class="w-full sm:w-1/2 lg:w-1/3 shrink-0 px-3"
          >
            <div class="bg-white rounded-2xl border border-brand-border p-6 flex flex-col justify-between h-full hover:shadow-xl hover:border-indigo-200 transition-all duration-300 group">
              <div>
                <!-- Image Frame -->
                <div class="w-full h-52 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-4 mb-5 overflow-hidden group-hover:bg-indigo-50/20 transition-colors">
                  <img 
                    :src="item.image" 
                    :alt="item.title" 
                    class="max-h-full max-w-full object-contain transform group-hover:scale-105 transition-transform duration-300"
                  />
                </div>

                <!-- Title & Text -->
                <h3 class="text-lg font-bold text-brand-navy group-hover:text-brand-indigo transition-colors leading-snug">
                  {{ item.title }}
                </h3>
                <p class="text-xs font-semibold text-brand-indigo mt-1 mb-2">{{ item.tagline }}</p>
                <p class="text-xs text-brand-slate leading-relaxed mb-6">{{ item.description }}</p>
              </div>

              <!-- Card Action Footer -->
              <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="text-xs font-medium text-slate-400">
                  {{ item.brands.join(' • ') }}
                </span>
                <Link 
                  href="/quote" 
                  class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-indigo hover:text-brand-hover group/link"
                >
                  <span>Get Quote</span>
                  <ArrowRight class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform" />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide Indicator Dots -->
      <div class="flex items-center justify-center gap-2 mt-8">
        <button 
          v-for="(_, index) in maxIndex + 1" 
          :key="index"
          @click="goToSlide(index)"
          class="h-2 rounded-full transition-all"
          :class="currentIndex === index ? 'w-8 bg-brand-indigo' : 'w-2 bg-slate-300 hover:bg-slate-400'"
          :aria-label="`Go to slide group ${index + 1}`"
        />
      </div>

    </div>
  </section>
</template>