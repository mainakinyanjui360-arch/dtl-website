<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Phone, Mail, MapPin, ChevronRight, ChevronDown, MessageSquare, ShieldCheck, ArrowRight } from 'lucide-vue-next';

const isShopMenuOpen = ref(false);

const shopCategories = [
  'Fiber Optic Products',
  'ICT Hardware',
  'PABX & IP Phones',
  'Professional AV',
  'Security Products',
  'Uncategorized'
];
</script>

<template>
  <div class="min-h-screen bg-brand-light flex flex-col font-sans text-brand-navy antialiased selection:bg-brand-indigo selection:text-white">
    <!-- Top Contact Strip -->
    <div class="bg-brand-navy text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
        <div class="flex items-center space-x-6">
          <span class="flex items-center gap-1.5 hover:text-white transition">
            <Phone class="w-3.5 h-3.5 text-brand-indigo" />
            +254 723 788354
          </span>
          <span class="flex items-center gap-1.5 hover:text-white transition">
            <Mail class="w-3.5 h-3.5 text-brand-indigo" />
            info@dignityafrica.co.ke
          </span>
          <span class="hidden md:flex items-center gap-1.5">
            <MapPin class="w-3.5 h-3.5 text-brand-indigo" />
            Muthaiga Square, Ground Floor, Nairobi
          </span>
        </div>
        <div class="flex items-center gap-4">
          <a href="https://wa.me/254723788354" target="_blank" class="flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-medium transition">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            WhatsApp Support
          </a>
        </div>
      </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-brand-border shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo -->
        <Link href="/" class="flex items-center gap-3">
            <img 
                src="/images/dtl-logo-preview.png" 
                alt="Dignity Traders Ltd - Simply Technology" 
                class="h-10 sm:h-12 w-auto object-contain" 
            />
        </Link>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center space-x-8 text-sm font-medium text-slate-600">
          <Link href="/" class="hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url === '/' }">Home</Link>
          
          <!-- Shop Mega Menu Trigger -->
          <div 
            class="relative h-20 flex items-center group cursor-pointer"
            @mouseenter="isShopMenuOpen = true"
            @mouseleave="isShopMenuOpen = false"
          >
            <Link href="/shop" class="flex items-center gap-1 hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url.startsWith('/shop') }">
              Shop <ChevronDown class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': isShopMenuOpen }" />
            </Link>

            <!-- Dropdown Box (Mega Menu) -->
            <transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 -translate-y-4"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 -translate-y-4"
            >
              <div 
                v-if="isShopMenuOpen"
                class="absolute top-20 left-1/2 -translate-x-1/2 w-[850px] bg-white rounded-2xl shadow-2xl border border-slate-100 flex overflow-hidden z-50 cursor-default"
                @click.stop
              >
                <!-- Left Colored Prominent Block -->
                <div class="w-1/3 bg-brand-navy p-8 text-white flex flex-col justify-between relative overflow-hidden">
                  <div class="absolute inset-0 bg-brand-indigo opacity-20 mix-blend-overlay"></div>
                  <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-6 leading-tight">Get in touch<br>with us</h3>
                    <div class="space-y-5 text-sm mt-8 font-medium">
                      <div class="flex items-center gap-3 hover:text-indigo-200 transition">
                        <Phone class="w-5 h-5 text-white" />
                        <span>0723 788 354</span>
                      </div>
                      <div class="flex items-center gap-3 hover:text-indigo-200 transition">
                        <MessageSquare class="w-5 h-5 text-white" />
                        <span>0723 788 354</span>
                      </div>
                      <div class="flex items-center gap-3 hover:text-indigo-200 transition">
                        <Mail class="w-5 h-5 text-white" />
                        <span class="text-xs">info@dignityafrica.co.ke</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Middle Content Block -->
                <div class="w-1/3 p-8 bg-white border-r border-slate-100 flex flex-col justify-center">
                  <h3 class="text-2xl font-bold text-brand-navy mb-4">
                    Why Buy From Us?
                  </h3>
                  <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    We supply verified OEM hardware directly from manufacturers. Every purchase is backed by our full local warranty, professional installation SLAs, and post-sales technical support.
                  </p>
                  <div>
                    <Link href="/about" class="inline-flex items-center gap-2 bg-brand-indigo text-white text-xs font-bold px-5 py-2.5 rounded-lg hover:bg-brand-hover transition-colors">
                      Read More <ArrowRight class="w-4 h-4" />
                    </Link>
                  </div>
                </div>

                <!-- Right Links Block -->
                <div class="w-1/3 p-8 bg-white">
                  <h3 class="text-2xl font-bold text-brand-navy mb-6">Categories</h3>
                  <ul class="space-y-1">
                    <li v-for="category in shopCategories" :key="category">
                      <Link 
                        :href="`/shop?category=${encodeURIComponent(category)}`" 
                        class="flex items-center justify-between group/link py-3 border-b border-slate-100 hover:border-brand-indigo/30 transition-colors"
                      >
                        <span class="text-sm text-slate-700 group-hover/link:text-brand-indigo font-medium transition-colors">{{ category }}</span>
                        <ArrowRight class="w-4 h-4 text-slate-300 group-hover/link:text-brand-indigo transform -translate-x-2 opacity-0 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" />
                      </Link>
                    </li>
                  </ul>
                </div>
              </div>
            </transition>
          </div>

          <Link href="/services" class="hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url.startsWith('/services') }">Services</Link>
          <Link href="/partners" class="hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url.startsWith('/partners') }">Partners</Link>
          <Link href="/about" class="hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url.startsWith('/about') }">About Us</Link>
          <Link href="/contact" class="hover:text-brand-indigo transition" :class="{ 'text-brand-indigo font-semibold': $page.url.startsWith('/contact') }">Contact</Link>
        </nav>

        <!-- Header CTA -->
        <div class="hidden sm:flex items-center gap-4">
          <Link href="/quote" class="inline-flex items-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow-sm shadow-brand-indigo/30 transition-all hover:shadow-md">
            <span>Request a Quote</span>
            <ChevronRight class="w-4 h-4" />
          </Link>
        </div>
      </div>
    </header>

    <!-- Page Body Slot -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Global Corporate Footer -->
    <footer class="bg-brand-navy text-slate-300 pt-16 pb-12 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
        <div class="lg:col-span-2 space-y-4">
  <Link href="/" class="inline-block">
    <img 
      src="/images/dtl-logo-preview.png" 
      alt="Dignity Traders Ltd" 
      class="h-10 sm:h-12 w-auto object-contain" 
    />
  </Link>
  <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
    Delivering trusted ICT and security solutions through enterprise-grade hardware, structured infrastructure, and responsive technical service across Kenya and Africa.
  </p>
</div>

        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Discover</h4>
          <ul class="space-y-2.5 text-sm text-slate-400">
            <li><Link href="/experience" class="hover:text-white transition">Experience</Link></li>
            <li><Link href="/projects" class="hover:text-white transition">Projects</Link></li>
            <li><Link href="/team" class="hover:text-white transition">Our Team</Link></li>
            <li><Link href="/faqs" class="hover:text-white transition">FAQs</Link></li>
            <li><Link href="/customers" class="hover:text-white transition">Customers</Link></li>
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Services</h4>
          <ul class="space-y-2.5 text-sm text-slate-400">
            <li><Link href="/services#cabling" class="hover:text-white transition">Structured Cabling</Link></li>
            <li><Link href="/services#cybersecurity" class="hover:text-white transition">Cybersecurity Solutions</Link></li>
            <li><Link href="/services#telecom" class="hover:text-white transition">PABX & IP Telephony</Link></li>
            <li><Link href="/services#maintenance" class="hover:text-white transition">SLA Support & Repair</Link></li>
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold text-sm mb-4 tracking-wider uppercase">Contact</h4>
          <p class="text-sm text-slate-400 leading-relaxed">
            Muthaiga Square, Ground Floor<br>
            Nairobi, Kenya<br>
            <span class="block mt-2 text-white font-medium">+254 723 788354</span>
            <span class="text-slate-400">info@dignityafrica.co.ke</span>
          </p>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-slate-800 text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
        <p>© 2026 Dignity Traders Limited. All Rights Reserved.</p>
        <p>Enterprise ICT Infrastructure & Procurement</p>
      </div>
    </footer>
  </div>
</template>