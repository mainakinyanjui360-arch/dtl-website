<script setup>
import { Quote, Star, Building2, CheckCircle2 } from 'lucide-vue-next';

const testimonials = [
  {
    quote: "Dignity Traders has consistently provided us with reliable ICT and networking solutions. Their technical expertise, quality products, and responsive support have made them a trusted technology partner for our business.",
    author: "Keel Timo",
    role: "IT Manager",
    company: "Corporate Client",
    deployment: "Enterprise LAN & Structured Cabling Rollout"
  },
  {
    quote: "Professional, responsive, and dependable. Dignity Traders understands our technology needs and consistently delivers quality solutions on time.",
    author: "Daniel Maina",
    role: "Lead Systems Architect",
    company: "Regional Technology Partner",
    deployment: "Server Infrastructure & Workstation Procurement"
  },
  {
    quote: "From Fortinet firewall installations to our CCTV surveillance backbone, their deployment team ensured zero downtime during our office expansion.",
    author: "Operations Director",
    role: "Head of Infrastructure",
    company: "Commercial Enterprise",
    deployment: "Turnkey CCTV & Perimeter Defense"
  }
];

const impactStats = [
  { value: "99.9%", label: "SLA Uptime Commitment" },
  { value: "500+", label: "Hardware Deployments" },
  { value: "24h", label: "Average RFP Response" },
  { value: "100%", label: "Direct OEM Sourced" }
];
</script>

<template>
  <section class="py-24 bg-white relative border-b border-brand-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Proven Enterprise Trust</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
          Delivering Confidence to Kenyan Enterprises
        </h2>
        <p class="text-brand-slate text-sm sm:text-base mt-2 leading-relaxed">
          See why IT managers, financial institutions, and corporate teams rely on Dignity Traders for turnkey ICT deployments and hardware reliability.
        </p>
      </div>

      <!-- Testimonial Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div 
          v-for="(item, index) in testimonials" 
          :key="index"
          class="bg-brand-light rounded-2xl p-8 border border-brand-border flex flex-col justify-between hover:shadow-lg hover:border-indigo-200 transition-all duration-300 relative group"
        >
          <div>
            <!-- Star Ratings & Quote Icon -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex text-amber-400 gap-1">
                <Star v-for="i in 5" :key="i" class="w-4 h-4 fill-amber-400" />
              </div>
              <Quote class="w-7 h-7 text-indigo-200 group-hover:text-brand-indigo transition-colors" />
            </div>

            <!-- Quote Text -->
            <p class="text-sm text-slate-700 leading-relaxed italic mb-6">
              "{{ item.quote }}"
            </p>
          </div>

          <!-- Bottom Client Meta -->
          <div class="pt-5 border-t border-slate-200/80">
            <div class="font-bold text-sm text-brand-navy">{{ item.author }}</div>
            <div class="text-xs text-brand-indigo font-medium">{{ item.role }} • {{ item.company }}</div>
            <div class="mt-2 inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-500 bg-white px-2.5 py-1 rounded-md border border-slate-200">
              <CheckCircle2 class="w-3 h-3 text-emerald-500" />
              <span>{{ item.deployment }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Proof Numbers Banner -->
      <div class="bg-brand-navy rounded-2xl p-8 sm:p-10 text-white shadow-xl">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
          <div v-for="stat in impactStats" :key="stat.label" class="pt-4 md:pt-0 first:pt-0">
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-400 font-mono mb-1">
              {{ stat.value }}
            </div>
            <div class="text-xs text-slate-300 font-medium tracking-wide">
              {{ stat.label }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>