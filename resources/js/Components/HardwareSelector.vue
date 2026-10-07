<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

defineProps({
  hardwareCategories: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <section class="py-24 bg-brand-light relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="mb-12 border-b border-brand-border pb-6">
        <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Procurement & Distribution</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
          Enterprise Hardware & Equipment
        </h2>
        <p class="text-brand-slate text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
          Directly sourced from authorized global OEMs. Backed by local replacement warranties and verified commercial reliability across Kenya.
        </p>
      </div>

      <!-- Marquee Viewport Window -->
      <div class="relative overflow-hidden w-full" v-if="hardwareCategories.length > 0">
        <!-- Moving Track -->
        <div class="flex gap-6 animate-marquee hover:[animation-play-state:paused] w-max">
          <!-- We render the list twice to create the infinite loop effect -->
          <div 
            v-for="(item, idx) in [...hardwareCategories, ...hardwareCategories]" 
            :key="`${item.id || item.title}-${idx}`"
            class="w-72 sm:w-80 shrink-0"
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
                  href="/contact" 
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

    </div>
  </section>
</template>

<style scoped>
@keyframes marquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-marquee {
  animation: marquee 30s linear infinite;
}
</style>