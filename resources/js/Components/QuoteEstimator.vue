<script setup>
import { reactive, ref } from 'vue';
import { Send, CheckCircle2 } from 'lucide-vue-next';

const form = reactive({
  scope: 'hardware',
  scale: 'mid',
  company: '',
  contact: '',
  details: ''
});

const isSubmitted = ref(false);

const submitEstimate = () => {
  // Can be tied directly to a Laravel Inertia form helper or standard POST
  isSubmitted.value = true;
};
</script>

<template>
  <section class="py-24 bg-brand-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="bg-brand-navy rounded-3xl overflow-hidden shadow-2xl border border-slate-800 text-white grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Explainer Panel -->
        <div class="lg:col-span-5 p-8 sm:p-12 lg:p-14 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-slate-800 bg-gradient-to-br from-brand-navy via-slate-900 to-brand-surface">
          <div>
            <span class="text-xs uppercase tracking-widest text-indigo-400 font-bold">Fast RFP & Quotations</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2 text-white leading-tight">
              Plan Your Technology Deployment
            </h2>
            <p class="text-slate-300 text-sm mt-4 leading-relaxed">
              Select your requirements and get a verified proposal with official OEM pricing, warranty terms, and implementation timelines.
            </p>

            <div class="mt-8 space-y-4 text-xs sm:text-sm text-slate-300">
              <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</div>
                <span>Itemized B2B quotations within 24 business hours</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</div>
                <span>Direct authorized warranties across Kenya</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</div>
                <span>Site survey and assessment available on request</span>
              </div>
            </div>
          </div>

          <div class="mt-12 pt-8 border-t border-slate-800 text-xs text-slate-400">
            Direct Corporate Desk: <strong class="text-white">+254 723 788354</strong> • info@dignityafrica.co.ke
          </div>
        </div>

        <!-- Right Interactive Form -->
        <div class="lg:col-span-7 p-8 sm:p-12 lg:p-14 bg-slate-900/90">
          <div v-if="isSubmitted" class="text-center py-16 space-y-4">
            <CheckCircle2 class="w-16 h-16 text-emerald-400 mx-auto" />
            <h3 class="text-2xl font-bold text-white">Quotation Request Received</h3>
            <p class="text-slate-300 text-sm max-w-md mx-auto">
              Our enterprise sales and solutions desk is preparing your proposal and will reach out shortly.
            </p>
          </div>

          <form v-else @submit.prevent="submitEstimate" class="space-y-6">
            <!-- Step 1: Scope Selector -->
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2.5">
                1. Select Primary Requirement
              </label>
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs font-medium">
                <button
                  type="button"
                  @click="form.scope = 'hardware'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scope === 'hardware' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  Hardware Procurement
                </button>
                <button
                  type="button"
                  @click="form.scope = 'networking'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scope === 'networking' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  Network & Fibre
                </button>
                <button
                  type="button"
                  @click="form.scope = 'security'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scope === 'security' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  CCTV & Access
                </button>
                <button
                  type="button"
                  @click="form.scope = 'maintenance'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scope === 'maintenance' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  SLA Support
                </button>
              </div>
            </div>

            <!-- Step 2: Scale Selector -->
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2.5">
                2. Enterprise Scale
              </label>
              <div class="grid grid-cols-3 gap-2.5 text-xs font-medium">
                <button
                  type="button"
                  @click="form.scale = 'small'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scale === 'small' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  1 – 20 Users / Ports
                </button>
                <button
                  type="button"
                  @click="form.scale = 'mid'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scale === 'mid' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  20 – 100 Users / Multi-room
                </button>
                <button
                  type="button"
                  @click="form.scale = 'enterprise'"
                  class="p-3 rounded-xl border text-center transition-all"
                  :class="form.scale === 'enterprise' ? 'bg-brand-indigo border-brand-indigo text-white shadow-sm' : 'border-slate-700 bg-slate-800/80 text-slate-300 hover:border-slate-600'"
                >
                  Enterprise 100+ / Multi-branch
                </button>
              </div>
            </div>

            <!-- Step 3: Contact Inputs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs text-slate-300 mb-1.5">Company / Institution Name</label>
                <input 
                  v-model="form.company" 
                  type="text" 
                  required 
                  placeholder="e.g. Apex Logistics Ltd"
                  class="w-full bg-slate-800/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-indigo"
                />
              </div>
              <div>
                <label class="block text-xs text-slate-300 mb-1.5">Phone or Email Address</label>
                <input 
                  v-model="form.contact" 
                  type="text" 
                  required 
                  placeholder="phone or email"
                  class="w-full bg-slate-800/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-indigo"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs text-slate-300 mb-1.5">Optional Specifications / Device Quantities</label>
              <textarea 
                v-model="form.details" 
                rows="2" 
                placeholder="Specific model preference, number of workstations, or building layout..."
                class="w-full bg-slate-800/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-indigo"
              ></textarea>
            </div>

            <button 
              type="submit" 
              class="w-full bg-brand-indigo hover:bg-brand-hover text-white text-sm font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-brand-indigo/30 transition-all flex items-center justify-center gap-2"
            >
              <span>Submit for Official Quotation</span>
              <Send class="w-4 h-4" />
            </button>
          </form>
        </div>

      </div>

    </div>
  </section>
</template>