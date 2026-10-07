<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import PartnerTicker from '@/Components/PartnerTicker.vue';
import { 
  ArrowRight, 
  CheckCircle2, 
  ShieldCheck, 
  Target, 
  Eye, 
  Sparkles, 
  Download,
  Building,
  Network,
  ShieldAlert,
  Milestone
} from 'lucide-vue-next';

// High-impact corporate metrics
const companyStats = [
  { value: '10+', label: 'Years in Industry' },
  { value: '500+', label: 'Enterprise Deployments' },
  { value: '100%', label: 'Genuine OEM Sourcing' },
  { value: '24/7', label: 'Critical SLA Readiness' },
];

// Core company foundations
const pillars = [
  {
    title: 'Vision',
    subtitle: 'To be the preferred enterprise ICT & hardware infrastructure solutions partner across East Africa.',
    icon: Eye
  },
  {
    title: 'Mission',
    subtitle: 'To provide the most compelling security and ICT service experience, enabling customer freedom and choice through product knowledge, quality products, and affordable, on-time delivery.',
    icon: Target
  },
  {
    title: 'Motto',
    subtitle: 'Simply Technology — High performance infrastructure, zero operational bottlenecks.',
    icon: Sparkles
  }
];

const coreValues = [
  'Integrity & Transparency',
  'OEM-Backed Quality',
  'Customer Freedom of Choice',
  'Engineering Excellence',
  'Dependable SLA Support',
  'Continuous Innovation'
];

// Chronological corporate evolution
const journeyMilestones = [
  {
    year: '2016',
    title: 'Founding & Hardware Procurement',
    description: 'Established in Nairobi to provide verified commercial laptops, workstations, and servers backed by official manufacturer warranties.',
    icon: Building
  },
  {
    year: '2019',
    title: 'Dignity Fibre House & Cabling',
    description: 'Expanded into large-scale optical backbones, structured copper cabling, and data room server rack design across Kenya.',
    icon: Network
  },
  {
    year: '2022',
    title: 'Physical Security & OEM Alliances',
    description: 'Formed strategic deployment partnerships with Tier-1 brands including Fortinet, Hikvision, Dell, HP, and Cisco.',
    icon: ShieldAlert
  },
  {
    year: '2026',
    title: 'Turnkey ICT Systems Integration',
    description: 'Operating out of Muthaiga Square, Nairobi, delivering managed SLAs, enterprise telecom, and multi-branch infrastructure rollouts.',
    icon: Milestone
  }
];
</script>

<template>
  <Head title="Who We Are - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- 1. Hero with Breadcrumb & Corporate Backdrop -->
    <section class="relative bg-brand-navy text-white py-20 lg:py-28 overflow-hidden">
      <!-- Background Image with Calibrated Contrast -->
      <div class="absolute inset-0 z-0">
        <img 
          src="/images/hero/infrastructure.jpg" 
          alt="Dignity Traders Corporate Team" 
          class="w-full h-full object-cover object-center opacity-50"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium mb-4">
          <Link href="/" class="hover:text-white transition">Home</Link>
          <span class="text-slate-500">/</span>
          <span class="text-indigo-300 font-semibold">Who We Are</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          About Us
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Who We Are
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          Building dependable enterprise ICT infrastructure, authorized hardware supply, and intelligent security solutions for modern institutions across Kenya and Africa.
        </p>
      </div>
    </section>

    <!-- 2. Narrative Overview & Quick Numbers Ribbon -->
    <section class="py-16 sm:py-20 bg-white border-b border-brand-border">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Two-Column Narrative Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch mb-14">
          
          <!-- Left Spotlight Intro Card -->
          <div class="lg:col-span-4 bg-brand-light p-6 sm:p-8 rounded-2xl border border-brand-border flex flex-col justify-between">
            <div>
              <span class="text-xs uppercase tracking-widest text-brand-indigo font-bold block mb-2">
                Enterprise Heritage
              </span>
              <h2 class="text-xl sm:text-2xl font-extrabold text-brand-navy leading-snug">
                Dignity Traders Limited (DTL) is an established technology systems integrator.
              </h2>
              <p class="text-xs sm:text-sm text-brand-slate mt-3 leading-relaxed">
                Operating from Muthaiga Square, Nairobi, we equip institutions with genuine hardware, structured cabling, optical fibre, and physical security across East Africa.
              </p>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-200">
              <a 
                href="/company-profile.pdf" 
                download 
                class="inline-flex items-center gap-2 text-xs font-bold text-brand-indigo hover:text-brand-hover transition"
              >
                <Download class="w-4 h-4" />
                <span>Download Corporate Profile</span>
              </a>
            </div>
          </div>

          <!-- Right Narrative Columns -->
          <div class="lg:col-span-8 flex flex-col justify-center space-y-4 text-sm text-brand-slate leading-relaxed">
            <p>
              We established Dignity Traders Limited to deliver a dependable technology experience that prioritizes quality, transparency, and timely execution. By supplying verified OEM-certified equipment, we eliminate the operational risks and premature failures common with unauthorized gray-market channels.
            </p>
            <p>
              Our capabilities cover end-to-end IT rollouts—from commercial workstations and enterprise servers to turnkey optical backbones and intelligent CCTV surveillance. Every project follows strict international cabling standards and is supported by responsive local SLAs to keep your operations running without downtime.
            </p>
          </div>

        </div>

        <!-- Numbers Ribbon -->
        <div class="bg-brand-navy rounded-2xl p-6 sm:p-8 text-white shadow-xl">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <div 
              v-for="(stat, idx) in companyStats" 
              :key="stat.label" 
              class="pt-4 md:pt-0"
              :class="{ 'border-t-0': idx < 2 }"
            >
              <div class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-indigo-400 font-mono mb-1">
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

    <!-- 3. Foundations Strip: Vision, Mission, Motto & Core Values -->
    <section class="py-20 bg-brand-light border-b border-brand-border">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
          <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Corporate Guiding Principles</span>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
            Our Purpose, Promise & Values
          </h2>
          <p class="text-brand-slate text-sm sm:text-base mt-2">
            Our mission, vision, and core values shape every technical engagement, ensuring transparency, engineering quality, and lasting client value.
          </p>
        </div>

        <!-- 4-Card Foundations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
          
          <!-- Vision, Mission, Motto Cards -->
          <div 
            v-for="p in pillars" 
            :key="p.title"
            class="bg-white rounded-2xl p-6 border border-brand-border flex flex-col justify-between hover:shadow-lg hover:border-indigo-200 transition-all"
          >
            <div>
              <div class="w-10 h-10 rounded-xl bg-indigo-50 text-brand-indigo flex items-center justify-center mb-4">
                <component :is="p.icon" class="w-5 h-5" />
              </div>
              <h3 class="text-lg font-bold text-brand-navy mb-2">{{ p.title }}</h3>
              <p class="text-xs text-brand-slate leading-relaxed">
                {{ p.subtitle }}
              </p>
            </div>
          </div>

          <!-- Core Values Card (Listing Format) -->
          <div class="bg-white rounded-2xl p-6 border border-brand-border flex flex-col justify-between hover:shadow-lg hover:border-indigo-200 transition-all">
            <div>
              <div class="w-10 h-10 rounded-xl bg-indigo-50 text-brand-indigo flex items-center justify-center mb-4">
                <ShieldCheck class="w-5 h-5" />
              </div>
              <h3 class="text-lg font-bold text-brand-navy mb-3">Core Values</h3>
              <ul class="space-y-2 text-xs text-brand-slate font-medium">
                <li v-for="val in coreValues" :key="val" class="flex items-center gap-2">
                  <span class="text-brand-indigo font-bold">›</span>
                  <span>{{ val }}</span>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 4. Executive Milestone Progression Roadmap -->
    <section class="py-24 bg-white border-b border-brand-border relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 pb-6 border-b border-slate-200/80">
          <div>
            <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase">Corporate Evolution</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-navy tracking-tight mt-1">
              A Decade of Technological Precision
            </h2>
          </div>
          <p class="mt-4 md:mt-0 text-sm text-brand-slate max-w-md leading-relaxed">
            From verified commercial hardware distribution to turnkey regional systems integration across Kenya and East Africa.
          </p>
        </div>

        <!-- Desktop: 4 Horizontal Connected Stages -->
        <div class="hidden lg:grid grid-cols-4 gap-8 relative">
          <div class="absolute top-6 left-6 right-6 h-0.5 bg-slate-200 z-0"></div>

          <div 
            v-for="(item, index) in journeyMilestones" 
            :key="item.year"
            class="relative z-10 flex flex-col pt-1 group"
          >
            <div class="flex items-center gap-3 mb-6">
              <div class="w-11 h-11 rounded-xl bg-white border-2 border-brand-indigo flex items-center justify-center text-brand-indigo font-bold text-xs shadow-sm group-hover:bg-brand-indigo group-hover:text-white transition-all duration-300">
                <component :is="item.icon" class="w-5 h-5" />
              </div>
              <span class="px-2.5 py-0.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-indigo text-xs font-mono font-bold tracking-wider">
                {{ item.year }}
              </span>
            </div>

            <div class="bg-brand-light rounded-2xl p-6 border border-brand-border flex-grow flex flex-col justify-between shadow-xs group-hover:shadow-lg group-hover:bg-white group-hover:border-indigo-200 transition-all duration-300">
              <div>
                <h3 class="text-base font-bold text-brand-navy mb-2.5 leading-snug group-hover:text-brand-indigo transition-colors">
                  {{ item.title }}
                </h3>
                <p class="text-xs text-brand-slate leading-relaxed">
                  {{ item.description }}
                </p>
              </div>
              <div class="mt-5 pt-4 border-t border-slate-200 flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                <span>Phase 0{{ index + 1 }}</span>
                <span class="text-slate-300">•</span>
                <span class="text-emerald-600 font-medium">Established</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile & Tablet: Left-Bordered Vertical Timeline -->
        <div class="lg:hidden relative border-l-2 border-slate-200 ml-4 pl-6 space-y-10">
          <div 
            v-for="(item, index) in journeyMilestones" 
            :key="item.year"
            class="relative"
          >
            <div class="absolute -left-[35px] top-1.5 w-7 h-7 rounded-lg bg-brand-navy border-2 border-white text-indigo-300 flex items-center justify-center shadow-xs">
              <component :is="item.icon" class="w-3.5 h-3.5" />
            </div>

            <span class="inline-block px-2.5 py-0.5 rounded bg-indigo-50 border border-indigo-100 text-brand-indigo text-xs font-mono font-bold mb-2">
              {{ item.year }}
            </span>

            <div class="bg-brand-light rounded-xl p-5 border border-brand-border shadow-xs">
              <h3 class="text-base font-bold text-brand-navy mb-1.5 leading-snug">
                {{ item.title }}
              </h3>
              <p class="text-xs text-brand-slate leading-relaxed">
                {{ item.description }}
              </p>
              <div class="mt-4 pt-3 border-t border-slate-200 text-[11px] font-medium text-slate-400">
                Phase 0{{ index + 1 }} • Milestone
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 5. Technology Partner Ecosystem Strip -->
    <PartnerTicker />

    <!-- 6. High-Conversion Callout -->
    <section class="py-20 bg-brand-light">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-brand-navy rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8">
          <div class="space-y-3 text-center md:text-left">
            <span class="text-xs uppercase tracking-widest text-indigo-400 font-bold block">Start Your Project</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
              Ready to Partner with Dignity Traders?
            </h3>
            <p class="text-slate-300 text-sm max-w-lg leading-relaxed">
              Equip your enterprise with genuine OEM workstations, reliable optical fibre cabling, or intelligent physical security.
            </p>
          </div>

          <div class="flex flex-col sm:flex-row gap-3 shrink-0 w-full sm:w-auto">
            <Link 
              href="/contact" 
              class="inline-flex items-center justify-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white text-xs font-bold px-6 py-3.5 rounded-xl shadow-md transition-all"
            >
              <span>Speak to an Engineer</span>
              <ArrowRight class="w-4 h-4" />
            </Link>
            <Link 
              href="/contact" 
              class="inline-flex items-center justify-center gap-2 bg-slate-800/80 hover:bg-slate-800 border border-slate-700 text-white text-xs font-semibold px-6 py-3.5 rounded-xl transition-all"
            >
              <span>Request Quote</span>
            </Link>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>