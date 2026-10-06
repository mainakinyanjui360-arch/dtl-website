<script setup>
import { Link } from '@inertiajs/vue3';
import { Network, ShieldCheck, PhoneCall, Wrench, ArrowRight } from 'lucide-vue-next';

const services = [
  {
    icon: Network,
    title: 'Structured Cabling & Fiber Optics',
    tagline: 'High-Speed Enterprise Backbones',
    description: 'Cat6/6A copper infrastructure, optical fibre trunking, server rack cleanups, and patch panel terminations tested to Fluke enterprise standards.',
    highlights: ['Multi-floor corporate backbones', 'Fibre splicing & OTDR testing', 'Rack cable management & labeling']
  },
  {
    icon: ShieldCheck,
    title: 'Cybersecurity & Perimeter Defense',
    tagline: 'Enterprise Threat Mitigation',
    description: 'Next-generation Fortinet and Cisco firewall deployments, site-to-site VPN tunneling, intrusion prevention, and endpoint security compliance.',
    highlights: ['Next-Gen firewall configuration', 'Zero Trust access controls', 'Vulnerability audits & mitigation']
  },
  {
    icon: PhoneCall,
    title: 'PABX & IP Unified Communications',
    tagline: 'Modern Corporate Telephony',
    description: 'Modern IP-PBX systems, VoIP SIP trunks, multi-office interbranch calling, and integrated boardroom video conferencing solutions.',
    highlights: ['Hybrid on-prem & cloud PBX', 'Boardroom conferencing AV', 'Interactive IVR & call routing']
  },
  {
    icon: Wrench,
    title: 'SLA Support & IT Maintenance Contracts',
    tagline: 'Guaranteed Operational Uptime',
    description: 'Preventive and scheduled maintenance agreements ensuring minimal system downtime, rapid hardware replacement, and emergency engineer dispatch.',
    highlights: ['Strict SLA response timelines', 'Scheduled preventive checkups', 'Emergency on-site troubleshooting']
  }
];
</script>

<template>
  <section class="py-24 bg-white relative border-b border-brand-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
        <div>
          <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Engineering Capabilities</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
            Enterprise ICT & Infrastructure Services
          </h2>
          <p class="text-brand-slate text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
            From design and cabling to active configuration and long-term maintenance, our certified technicians deploy robust digital infrastructure.
          </p>
        </div>

        <div class="mt-6 md:mt-0 shrink-0">
          <Link 
            href="/services" 
            class="inline-flex items-center gap-2 text-sm font-bold text-brand-indigo hover:text-brand-hover transition-colors group"
          >
            <span>Explore All Solutions</span>
            <ArrowRight class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
          </Link>
        </div>
      </div>

      <!-- Services 4-Column Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div 
          v-for="service in services" 
          :key="service.title"
          class="bg-brand-light rounded-2xl p-7 border border-brand-border flex flex-col justify-between hover:bg-white hover:border-indigo-200 hover:shadow-xl transition-all duration-300 group"
        >
          <div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 text-brand-indigo flex items-center justify-center mb-6 group-hover:bg-brand-indigo group-hover:text-white group-hover:border-brand-indigo transition-all duration-300 shadow-xs">
              <component :is="service.icon" class="w-6 h-6" />
            </div>

            <h3 class="text-lg font-bold text-brand-navy group-hover:text-brand-indigo transition-colors leading-snug">
              {{ service.title }}
            </h3>
            <p class="text-xs font-semibold text-brand-indigo mt-1 mb-3">{{ service.tagline }}</p>
            <p class="text-xs text-brand-slate leading-relaxed mb-6">{{ service.description }}</p>

            <!-- Highlights Checklist -->
            <ul class="space-y-2.5 border-t border-slate-200/80 pt-4 mb-6">
              <li 
                v-for="item in service.highlights" 
                :key="item"
                class="flex items-center gap-2 text-xs text-slate-600 font-medium"
              >
                <span class="w-1.5 h-1.5 rounded-full bg-brand-indigo shrink-0"></span>
                <span>{{ item }}</span>
              </li>
            </ul>
          </div>

          <!-- Bottom Action -->
          <div class="pt-4 border-t border-slate-200/80 mt-auto">
            <Link 
              href="/quote" 
              class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-indigo hover:text-brand-hover group/link"
            >
              <span>Consult an Engineer</span>
              <ArrowRight class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform" />
            </Link>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>