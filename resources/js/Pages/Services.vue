<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
  Network, 
  ShieldAlert, 
  Server, 
  Wrench,
  ClipboardCheck,
  PenTool,
  CheckCircle,
  LifeBuoy,
  ArrowRight
} from 'lucide-vue-next';

const activeService = ref(null);

const toggleService = (title) => {
  activeService.value = activeService.value === title ? null : title;
};

const services = [
  {
    title: 'Structured Cabling & Fiber Optics',
    description: 'Design and installation of robust structured cabling systems and high-speed fiber optic networks to ensure seamless data flow across your organization.',
    icon: Network,
    features: ['Cat6/Cat6A Copper Cabling', 'Single/Multi-mode Fiber', 'Server Room Design', 'Cable Auditing & Labeling']
  },
  {
    title: 'Cybersecurity & Firewalls',
    description: 'Enterprise-grade security solutions including firewall configuration, network monitoring, and threat prevention to protect your digital assets.',
    icon: ShieldAlert,
    features: ['Fortinet & Sophos Firewalls', 'VPN Setup', 'Intrusion Detection (IDS/IPS)', 'Endpoint Security']
  },
  {
    title: 'IP Telephony & PABX Systems',
    description: 'Modern business communication solutions, offering scalable and crystal-clear IP telephony for seamless internal and external connectivity.',
    icon: Server,
    features: ['VoIP Infrastructure', 'Call Center Solutions', 'SIP Trunking', 'Unified Communications']
  },
  {
    title: 'SLA Maintenance & Support',
    description: 'Dedicated Service Level Agreements ensuring your hardware and software infrastructure remains operational with minimal downtime.',
    icon: Wrench,
    features: ['24/7 Monitoring', 'Preventative Maintenance', 'On-Site Technician Support', 'Hardware Replacement']
  }
];

const methodology = [
  { step: '01', title: 'Consultation & Audit', description: 'We start by evaluating your current infrastructure to identify bottlenecks and vulnerabilities.', icon: ClipboardCheck },
  { step: '02', title: 'System Design', description: 'Our engineers draft a scalable, cost-effective blueprint tailored to your organizational goals.', icon: PenTool },
  { step: '03', title: 'Implementation', description: 'Seamless deployment of hardware and networks with minimal disruption to your daily operations.', icon: CheckCircle },
  { step: '04', title: 'Ongoing Support', description: 'Continuous monitoring, routine maintenance, and dedicated SLA support to ensure 100% uptime.', icon: LifeBuoy }
];
</script>

<template>
  <Head title="Our Services - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- Header Banner -->
    <section class="relative bg-brand-navy text-white py-20 lg:py-28 overflow-hidden">
      <!-- Background Image -->
      <div class="absolute inset-0 z-0">
        <img 
          src="/images/hero/infrastructure.jpg" 
          alt="Services at Dignity Traders" 
          class="w-full h-full object-cover object-center opacity-50"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium mb-4">
          <Link href="/" class="hover:text-white transition">Home</Link>
          <span class="text-slate-500">/</span>
          <span class="text-indigo-300 font-semibold">Our Services</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          What We Do
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Enterprise ICT Services
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          Delivering end-to-end technology solutions to streamline your operations, enhance security, and scale your business efficiently.
        </p>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="py-20 bg-brand-light">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-3xl font-bold text-brand-navy">Professional IT Services</h2>
          <p class="mt-4 text-brand-slate">
            Beyond hardware, we provide the technical expertise to build, secure, and maintain your critical business infrastructure.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div 
            v-for="service in services" 
            :key="service.title" 
            @click="toggleService(service.title)"
            class="group cursor-pointer bg-white p-8 rounded-2xl border transition-all duration-300"
            :class="[
              activeService === service.title 
                ? 'border-brand-indigo shadow-lg ring-1 ring-brand-indigo/20' 
                : 'border-brand-border shadow-sm hover:shadow-md hover:border-indigo-200'
            ]"
          >
            <div class="flex items-center justify-between mb-6">
              <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-300"
                :class="activeService === service.title ? 'bg-brand-indigo text-white' : 'bg-indigo-50 text-brand-indigo group-hover:bg-indigo-100'"
              >
                <component :is="service.icon" class="w-6 h-6" />
              </div>
              
              <!-- Chevron or Plus icon indicating expand -->
              <div 
                class="w-8 h-8 rounded-full flex items-center justify-center bg-slate-50 text-slate-400 transition-transform duration-300"
                :class="{ 'rotate-180 bg-indigo-50 text-brand-indigo': activeService === service.title }"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>

            <h3 class="text-xl font-bold text-brand-navy mb-3 transition-colors duration-300"
              :class="{ 'text-brand-indigo': activeService === service.title }"
            >
              {{ service.title }}
            </h3>
            <p class="text-brand-slate text-sm leading-relaxed">
              {{ service.description }}
            </p>
            
            <!-- Expandable Features -->
            <div 
              class="overflow-hidden transition-all duration-500 ease-in-out"
              :style="{ maxHeight: activeService === service.title ? '250px' : '0', opacity: activeService === service.title ? '1' : '0' }"
            >
              <div class="pt-5 mt-5 border-t border-slate-100">
                <ul class="space-y-3">
                  <li v-for="feature in service.features" :key="feature" class="flex items-center gap-2.5 text-sm text-brand-slate font-medium">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                    {{ feature }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Methodology Section -->
    <section class="py-24 bg-white border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="text-brand-indigo font-bold tracking-widest text-xs uppercase">Our Approach</span>
          <h2 class="text-3xl font-bold text-brand-navy mt-2">Proven Implementation Methodology</h2>
          <p class="mt-4 text-brand-slate text-sm">
            We don't just sell equipment; we deliver end-to-end solutions. Our four-step process guarantees project success from planning to launch.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="step in methodology" :key="step.step" class="relative group">
            <div class="hidden lg:block absolute top-6 left-24 right-0 h-0.5 bg-slate-100 group-last:hidden"></div>
            <div class="relative z-10 w-12 h-12 rounded-full bg-white border-4 border-slate-50 flex items-center justify-center shadow-sm text-brand-indigo mb-6 mx-auto lg:mx-0">
              <component :is="step.icon" class="w-5 h-5" />
            </div>
            <div class="text-center lg:text-left">
              <span class="text-indigo-200 font-mono font-bold text-3xl block mb-2">{{ step.step }}</span>
              <h4 class="text-lg font-bold text-brand-navy mb-2">{{ step.title }}</h4>
              <p class="text-xs text-brand-slate leading-relaxed">{{ step.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-brand-navy text-white relative overflow-hidden">
      <!-- Decorative BG elements -->
      <div class="absolute inset-0 z-0 opacity-10">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-indigo-500 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-emerald-500 blur-3xl"></div>
      </div>
      
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-6">
          Ready to Upgrade Your Enterprise Infrastructure?
        </h2>
        <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-10 max-w-2xl mx-auto">
          Partner with Dignity Traders today. Get a free consultation on structured cabling, network security, or SLA management for your institution.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link href="/quote" class="inline-flex items-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white text-sm font-bold px-8 py-3.5 rounded-xl transition-all shadow-lg hover:shadow-indigo-500/30">
            <span>Request a Custom Quote</span>
            <ArrowRight class="w-4 h-4" />
          </Link>
          <Link href="/contact" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 hover:border-slate-600 text-sm font-semibold px-8 py-3.5 rounded-xl transition-all">
            Contact Our Engineers
          </Link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>
