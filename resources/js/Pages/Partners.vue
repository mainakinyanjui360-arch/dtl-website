<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PartnerTicker from '@/Components/PartnerTicker.vue';
import { ShieldCheck, Award, Handshake, Users, ArrowRight } from 'lucide-vue-next';

const partners = [
  { name: 'Cisco', tier: 'Premier Partner', description: 'Enterprise networking and cybersecurity solutions.' },
  { name: 'Fortinet', tier: 'Gold Partner', description: 'Next-generation firewalls and unified threat management.' },
  { name: 'Dell Technologies', tier: 'Authorized Reseller', description: 'Enterprise servers, storage, and computing solutions.' },
  { name: 'HP Enterprise', tier: 'Authorized Reseller', description: 'Cloud computing and advanced infrastructure.' },
  { name: 'Hikvision', tier: 'Integration Partner', description: 'Advanced physical security and surveillance systems.' },
  { name: 'Ubiquiti', tier: 'Certified Installer', description: 'Wireless networking and unified communications.' }
];

const customerSectors = [
  {
    sector: 'Financial Institutions',
    description: 'Securing critical data centers, branch networking, and continuous power solutions for banks and SACCOs.',
    icon: ShieldCheck
  },
  {
    sector: 'Government & Parastatals',
    description: 'Providing robust infrastructure, structured cabling, and compliant procurement for public sector offices.',
    icon: Award
  },
  {
    sector: 'Corporate Enterprises',
    description: 'Delivering end-to-end office networking, unified communications, and endpoint security.',
    icon: Handshake
  },
  {
    sector: 'Education & Healthcare',
    description: 'Building scalable campus Wi-Fi, secure patient data networks, and surveillance systems.',
    icon: Users
  }
];
</script>

<template>
  <Head title="Partners & Customers - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- Hero Section -->
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
          <span class="text-indigo-300 font-semibold">Partners & Customers</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          Our Network
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Trusted Alliances & Clients
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          We bridge the gap between global technology manufacturers and East African enterprises, ensuring genuine products and dedicated local support.
        </p>
      </div>
    </section>

    <!-- Global Technology Partners -->
    <section class="py-20 bg-slate-50 border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
          <h2 class="text-3xl font-extrabold text-brand-navy tracking-tight mb-4">Global Technology Partners</h2>
          <p class="text-lg text-slate-500">We hold direct authorizations and integration partnerships with the world's leading infrastructure OEMs.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="partner in partners" 
            :key="partner.name"
            class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col items-center text-center group"
          >
            <!-- Logo Placeholder -->
            <div class="w-24 h-24 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mb-6 group-hover:scale-105 transition-transform">
              <span class="text-brand-navy font-black text-xl uppercase tracking-wider">{{ partner.name.substring(0,2) }}</span>
            </div>
            <h3 class="text-xl font-bold text-brand-navy mb-1">{{ partner.name }}</h3>
            <span class="inline-block px-3 py-1 bg-brand-indigo/10 text-brand-indigo text-xs font-bold rounded-full mb-4">{{ partner.tier }}</span>
            <p class="text-slate-500 text-sm leading-relaxed">{{ partner.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Customer Sectors -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          
          <div class="lg:col-span-5">
            <h2 class="text-3xl font-extrabold text-brand-navy tracking-tight mb-6">Who We Serve</h2>
            <p class="text-lg text-slate-500 leading-relaxed mb-8">
              From secure financial networks to scalable corporate infrastructure, our solutions are trusted by diverse organizations across the region to maintain zero operational bottlenecks.
            </p>
            <Link href="/projects" class="inline-flex items-center gap-2 bg-brand-navy hover:bg-brand-indigo text-white px-6 py-3 rounded-lg font-bold transition-colors shadow-md">
              View Our Projects
              <ArrowRight class="w-4 h-4" />
            </Link>
          </div>

          <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div 
              v-for="sector in customerSectors" 
              :key="sector.sector"
              class="bg-slate-50 p-6 rounded-2xl border border-slate-100"
            >
              <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center mb-4 shadow-sm">
                <component :is="sector.icon" class="w-6 h-6 text-brand-indigo" />
              </div>
              <h3 class="text-lg font-bold text-brand-navy mb-2">{{ sector.sector }}</h3>
              <p class="text-sm text-slate-500 leading-relaxed">{{ sector.description }}</p>
            </div>
          </div>
          
        </div>
      </div>
    </section>

    <!-- Partner Ticker -->
    <PartnerTicker />

  </PublicLayout>
</template>
