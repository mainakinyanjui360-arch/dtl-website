<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Briefcase, ArrowRight, Server, Activity, Database, ShieldCheck, TrendingUp, Lock } from 'lucide-vue-next';

const props = defineProps({
  projects: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <Head title="Our Projects - Dignity Traders Ltd" />

  <PublicLayout>

    <!-- Header Banner -->
    <section class="relative bg-brand-navy text-white py-20 lg:py-28 overflow-hidden">
      <!-- Background Image with Calibrated Contrast -->
      <div class="absolute inset-0 z-0">
        <img 
          src="/images/hero/infrastructure.jpg" 
          alt="Contact Dignity Traders" 
          class="w-full h-full object-cover object-center opacity-50"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium mb-4">
          <Link href="/" class="hover:text-white transition">Home</Link>
          <span class="text-slate-500">/</span>
          <span class="text-indigo-300 font-semibold">Our Projects</span>
        </nav>

        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-indigo/40 border border-brand-indigo/60 text-indigo-200 text-xs font-semibold tracking-wide uppercase mb-3">
          Portfolio
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white">
          Completed Projects
        </h1>
      
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
          Explore our track record of delivering enterprise-grade infrastructure, telecommunications, and security solutions across East Africa.
        </p>
      </div>
    </section>
    
    <!-- SOLUTIONS WE BUILD SECTION -->
    <section class="py-24 bg-white border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase mb-3 block">
            Solutions We Provide
          </span>
          <h2 class="text-3xl font-extrabold text-brand-navy mb-4">
            From ideas to fully functional digital products.
          </h2>
          <p class="text-slate-500">
            We build modern, reliable and secure solutions that help businesses grow, operate efficiently and serve their customers better.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div>
            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-brand-indigo mb-5">
              <Server class="w-5 h-5" />
            </div>
            <h3 class="font-bold text-brand-navy text-lg mb-2">Hardware Procurement</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Enterprise-grade servers, storage solutions, computing devices, and networking equipment.</p>
          </div>
          <div>
            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-brand-indigo mb-5">
              <Activity class="w-5 h-5" />
            </div>
            <h3 class="font-bold text-brand-navy text-lg mb-2">Structured Cabling</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Fiber optic installations, Cat6/6A networks, and intelligent data center infrastructure.</p>
          </div>
          <div>
            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-brand-indigo mb-5">
              <ShieldCheck class="w-5 h-5" />
            </div>
            <h3 class="font-bold text-brand-navy text-lg mb-2">Cybersecurity</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Next-generation firewalls, endpoint protection, CCTV systems, and access control.</p>
          </div>
          <div>
            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-brand-indigo mb-5">
              <Database class="w-5 h-5" />
            </div>
            <h3 class="font-bold text-brand-navy text-lg mb-2">Business Systems</h3>
            <p class="text-sm text-slate-500 leading-relaxed">CRM, HRM, ERP, custom management platforms, and specialized mobile applications.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FEATURED PROJECTS ZIG-ZAG LIST -->
    <section id="projects" class="py-24 bg-brand-light">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-center justify-between mb-12 border-b border-slate-200 pb-6">
          <div>
            <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase mb-1 block">Featured Projects</span>
            <h2 class="text-3xl font-extrabold text-brand-navy">Our Latest Work</h2>
            <p class="text-sm text-slate-500 mt-2">A selection of our recent projects, built to solve real business challenges.</p>
          </div>
          
        </div>

        <!-- Projects List -->
        <div class="space-y-8">
          <div 
            v-for="(project, index) in projects" 
            :key="project.id"
            class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col md:flex-row"
          >
            <!-- Image Area (Order changes based on even/odd) -->
            <div class="w-full md:w-1/2 p-6" :class="index % 2 !== 0 ? 'md:order-2' : ''">
              <div class="w-full h-full min-h-[300px] rounded-2xl bg-slate-100 overflow-hidden relative border border-slate-100 shadow-inner">
                <img v-if="project.image" :src="project.image" class="w-full h-full object-cover absolute inset-0">
                <div v-else class="absolute inset-0 flex items-center justify-center">
                  <Briefcase class="w-16 h-16 text-slate-200" />
                </div>
              </div>
            </div>

            <!-- Content Area -->
            <div class="w-full md:w-1/2 p-8 lg:p-12 flex flex-col justify-center" :class="index % 2 !== 0 ? 'md:order-1' : ''">
              <h3 class="text-2xl font-bold text-brand-navy mb-2">{{ project.title }}</h3>
              <p class="text-sm text-slate-400 font-medium mb-6">{{ project.client ? project.client : 'Infrastructure Project' }}</p>
              
              <p class="text-slate-600 leading-relaxed mb-8 flex-1">
                {{ project.description }}
              </p>

              <!-- Tags / Links Bottom Row -->
              <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-100 mt-auto">
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-indigo-50 text-brand-indigo text-xs font-bold rounded-full border border-indigo-100">
                    {{ project.category || 'Networking' }}
                  </span>
                  <span v-if="project.completion_date" class="px-3 py-1 bg-slate-50 text-slate-500 text-xs font-bold rounded-full border border-slate-200">
                    {{ new Date(project.completion_date).getFullYear() }}
                  </span>
                </div>
                
                <Link href="/contact" class="text-sm font-bold text-brand-indigo hover:text-brand-hover transition-colors flex items-center gap-1 group">
                  Discuss Similar Project <ArrowRight class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
                </Link>
              </div>
            </div>
          </div>
        </div>

        <div v-if="projects.length === 0" class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm">
          <Briefcase class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-xl font-bold text-brand-navy mb-2">No projects found</h3>
        </div>
      </div>
    </section>

    <!-- WHY WORK WITH US -->
    <section class="py-24 bg-white border-t border-slate-100 border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          
          <div class="lg:col-span-4">
            <span class="text-xs font-bold tracking-widest text-brand-indigo uppercase mb-3 block">Why Work With Us</span>
            <h2 class="text-3xl font-extrabold text-brand-navy mb-4">
              Your Strategic Technology Partner
            </h2>
            <p class="text-slate-500 leading-relaxed">
              We go beyond simply delivering hardware. Our engineers design, deploy, and maintain mission-critical ICT infrastructure that empowers your business to operate securely, efficiently, and at scale.
            </p>
          </div>

          <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div>
              <div class="w-10 h-10 flex items-center text-brand-indigo mb-4">
                <Briefcase class="w-8 h-8" stroke-width="1.5" />
              </div>
              <h3 class="font-bold text-brand-navy text-sm mb-2">End-to-End Execution</h3>
              <p class="text-xs text-slate-500 leading-relaxed">From initial site surveys and procurement to deployment and final testing.</p>
            </div>
            <div>
              <div class="w-10 h-10 flex items-center text-brand-indigo mb-4">
                <TrendingUp class="w-8 h-8" stroke-width="1.5" />
              </div>
              <h3 class="font-bold text-brand-navy text-sm mb-2">Scalable Infrastructure</h3>
              <p class="text-xs text-slate-500 leading-relaxed">Networks and systems designed to grow seamlessly alongside your operations.</p>
            </div>
            <div>
              <div class="w-10 h-10 flex items-center text-brand-indigo mb-4">
                <ShieldCheck class="w-8 h-8" stroke-width="1.5" />
              </div>
              <h3 class="font-bold text-brand-navy text-sm mb-2">Enterprise Security</h3>
              <p class="text-xs text-slate-500 leading-relaxed">Military-grade cybersecurity practices integrated into every layer of your network.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BOTTOM CTA -->
    <section class="py-16 bg-[#001E4C]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-8">
        <div>
          <span class="text-xs font-bold tracking-widest text-indigo-400 uppercase mb-2 block">Have a project in mind?</span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">
            Let's turn your idea into something real.
          </h2>
          <p class="text-indigo-200 text-sm">
            We're ready to help you build, improve and scale your digital solutions.
          </p>
        </div>
        <div class="shrink-0">
          <Link href="/contact" class="bg-brand-indigo text-white px-8 py-3.5 rounded-full font-bold text-sm hover:bg-brand-hover transition-colors flex items-center gap-2">
            Start a Project <ArrowRight class="w-4 h-4" />
          </Link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>
