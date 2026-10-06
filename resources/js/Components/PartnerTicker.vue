<script setup>
const partners = [
  { name: 'Fortinet', logo: '/images/partners/Fortinet-Logo.wine.svg', scale: 'scale-100' },  
  { name: 'Dell Technologies', logo: '/images/partners/Dell-Logo.wine.svg', scale: 'scale-110' },
  { name: 'HP Enterprise', logo: '/images/partners/Hewlett-Packard-Logo.wine.svg', scale: 'scale-110' },
  { name: 'Dignity Fibre House', logo: '/images/partners/dignityfh.png', scale: 'scale-90' },
  { name: 'Lenovo', logo: '/images/partners/Lenovo_K6_Power-Logo.wine.svg', scale: 'scale-110' },
  { name: 'Hikvision', logo: '/images/partners/Hikvision-Logo.wine.svg', scale: 'scale-110' },
  { name: 'Cisco', logo: '/images/partners/cisco.svg', scale: 'scale-110' },
];
</script>

<template>
  <div class="border-y border-brand-border bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <p class="text-center text-xs font-semibold uppercase tracking-wider text-slate-400 mb-6">
        Authorized Technology & Infrastructure Partners
      </p>

      <!-- Single Line Container with Tight Spacing -->
      <div class="flex flex-nowrap items-center justify-between gap-3 overflow-x-auto no-scrollbar py-2">
        <div
          v-for="partner in partners"
          :key="partner.name"
          class="shrink-0 flex items-center justify-center h-12 w-28 sm:w-32 transition-all duration-300 group"
        >
          <img
            :src="partner.logo"
            :alt="partner.name"
            class="max-h-full max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
            :class="partner.scale"
          />
        </div>
      </div>
    </div>
  </div>
</template>