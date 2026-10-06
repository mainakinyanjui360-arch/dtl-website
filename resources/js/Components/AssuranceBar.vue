<script setup>
import { ShieldCheck, Cpu, Truck } from 'lucide-vue-next';

const perks = [
  {
    icon: ShieldCheck,
    title: '100% Genuine OEM Sourcing',
    desc: 'Direct warranties and verified hardware from Dell, HP, Lenovo & Fortinet.'
  },
  {
    icon: Cpu,
    title: 'Rapid Technical Deployment',
    desc: 'On-site configuration, cabling, and enterprise maintenance SLAs.'
  },
  {
    icon: Truck,
    title: 'Direct B2B Procurement',
    desc: 'Fast formal quotations, corporate credit terms, and nationwide delivery in Kenya.'
  }
];
</script>

<template>
  <div class="bg-white border-b border-brand-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div 
          v-for="perk in perks" 
          :key="perk.title"
          class="flex items-start gap-4"
        >
          <div class="p-3 rounded-xl bg-indigo-50 text-brand-indigo shrink-0">
            <component :is="perk.icon" class="w-6 h-6" />
          </div>
          <div>
            <h4 class="text-base font-bold text-brand-navy leading-snug">{{ perk.title }}</h4>
            <p class="text-sm text-brand-slate mt-1 leading-relaxed">{{ perk.desc }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>