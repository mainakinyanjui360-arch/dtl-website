<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Phone, Mail, MapPin, ChevronRight, ChevronDown, MessageSquare, ShieldCheck, ArrowRight, ShoppingCart, Minus, Plus, Trash2, Menu, X } from 'lucide-vue-next';
import { useProductStore } from '@/Stores/useProductStore';

const productStore = useProductStore();
const isShopMenuOpen = ref(false);
const isMobileMenuOpen = ref(false);

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
            {{ $page.props.globalSettings?.contact_phone || '+254 723 788354' }}
          </span>
          <span class="flex items-center gap-1.5 hover:text-white transition">
            <Mail class="w-3.5 h-3.5 text-brand-indigo" />
            {{ $page.props.globalSettings?.contact_email || 'info@dignityafrica.co.ke' }}
          </span>
          <span class="hidden md:flex items-center gap-1.5">
            <MapPin class="w-3.5 h-3.5 text-brand-indigo" />
            {{ $page.props.globalSettings?.contact_address || 'Muthaiga Square, Ground Floor, Nairobi' }}
          </span>
        </div>
        <div class="flex items-center gap-6">

          <a :href="'https://wa.me/' + ($page.props.globalSettings?.contact_phone?.replace(/\D/g, '') || '254723788354')" target="_blank" class="flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-medium transition">
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
                        <span>{{ $page.props.globalSettings?.contact_phone || '0723 788 354' }}</span>
                      </div>
                      <div class="flex items-center gap-3 hover:text-indigo-200 transition">
                        <MessageSquare class="w-5 h-5 text-white" />
                        <span>{{ $page.props.globalSettings?.contact_phone || '0723 788 354' }}</span>
                      </div>
                      <div class="flex items-center gap-3 hover:text-indigo-200 transition">
                        <Mail class="w-5 h-5 text-white" />
                        <span class="text-xs">{{ $page.props.globalSettings?.contact_email || 'info@dignityafrica.co.ke' }}</span>
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

        <!-- Header CTA and Mobile Menu Toggle -->
        <div class="flex items-center gap-4">
          <div class="hidden sm:flex items-center gap-4">
            <Link href="/contact" class="inline-flex items-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white text-sm font-medium px-5 py-2.5 rounded-lg shadow-sm shadow-brand-indigo/30 transition-all hover:shadow-md">
              <span>Request a Quote</span>
              <ChevronRight class="w-4 h-4" />
            </Link>
          </div>
          
          <!-- Mobile Menu Toggle Button -->
          <button 
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="lg:hidden p-2 text-slate-600 hover:text-brand-indigo transition focus:outline-none"
          >
            <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
            <X v-else class="w-6 h-6" />
          </button>
        </div>
      </div>
      
      <!-- Mobile Navigation Menu -->
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-2"
      >
        <div v-if="isMobileMenuOpen" class="lg:hidden absolute top-20 left-0 w-full bg-white border-b border-slate-200 shadow-lg">
          <nav class="flex flex-col p-4 space-y-2">
            <Link @click="isMobileMenuOpen = false" href="/" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url === '/' }">Home</Link>
            <Link @click="isMobileMenuOpen = false" href="/shop" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url.startsWith('/shop') }">Shop</Link>
            <Link @click="isMobileMenuOpen = false" href="/services" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url.startsWith('/services') }">Services</Link>
            <Link @click="isMobileMenuOpen = false" href="/partners" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url.startsWith('/partners') }">Partners</Link>
            <Link @click="isMobileMenuOpen = false" href="/about" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url.startsWith('/about') }">About Us</Link>
            <Link @click="isMobileMenuOpen = false" href="/contact" class="px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-indigo rounded-lg transition" :class="{ 'text-brand-indigo bg-slate-50': $page.url.startsWith('/contact') }">Contact</Link>
            
            <div class="pt-4 mt-2 border-t border-slate-100 sm:hidden">
              <Link @click="isMobileMenuOpen = false" href="/contact" class="flex items-center justify-center w-full gap-2 bg-brand-indigo text-white text-base font-medium px-5 py-3 rounded-lg shadow-sm">
                <span>Request a Quote</span>
                <ChevronRight class="w-4 h-4" />
              </Link>
            </div>
          </nav>
        </div>
      </transition>
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
            <li><Link href="/about" class="hover:text-white transition">Experience</Link></li>
            <li><Link href="/projects" class="hover:text-white transition">Projects</Link></li>
            <li><Link href="/faqs" class="hover:text-white transition">FAQs</Link></li>
            <li><Link href="/partners" class="hover:text-white transition">Customers</Link></li>
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
            <span class="whitespace-pre-line">{{ $page.props.globalSettings?.contact_address || 'Muthaiga Square, Ground Floor\nNairobi, Kenya' }}</span><br>
            <span class="block mt-2 text-white font-medium">{{ $page.props.globalSettings?.contact_phone || '+254 723 788354' }}</span>
            <span class="text-slate-400">{{ $page.props.globalSettings?.contact_email || 'info@dignityafrica.co.ke' }}</span>
          </p>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-slate-800 text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
        <p>© 2026 Dignity Traders Limited. All Rights Reserved.</p>
        <p>Enterprise ICT Infrastructure & Procurement</p>
      </div>
    </footer>

    <!-- Global Slide-over Cart Panel -->
    <div v-if="productStore.isCartOpen" class="fixed inset-0 z-[100] overflow-hidden">
      <!-- Backdrop -->
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="productStore.isCartOpen = false"></div>
      
      <!-- Panel -->
      <div class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col transform transition-transform duration-300">
        <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50">
          <h2 class="text-xl font-bold text-brand-navy flex items-center gap-2">
            <ShoppingCart class="w-5 h-5 text-brand-indigo" />
            Your Request Cart
          </h2>
          <button @click="productStore.isCartOpen = false" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="flex-grow overflow-y-auto p-6">
          <div v-if="productStore.cart.length === 0" class="h-full flex flex-col items-center justify-center text-slate-400 space-y-4">
            <ShoppingCart class="w-16 h-16 opacity-20" />
            <p>Your cart is empty.</p>
            <button @click="isGlobalCartOpen = false" class="text-brand-indigo font-bold text-sm hover:underline">Continue Shopping</button>
          </div>

          <div v-else class="space-y-4">
            <div v-for="item in productStore.cart" :key="item.id" class="flex gap-3 p-3 rounded-xl border border-slate-100 bg-white shadow-sm">
              <div class="w-14 h-14 rounded-lg bg-slate-100 shrink-0 flex items-center justify-center text-[10px] font-bold text-slate-300 overflow-hidden">
                <img v-if="item.images && item.images.length > 0" :src="item.images.find(i => i.is_primary)?.image_path || item.images[0].image_path" class="w-full h-full object-cover" />
                <span v-else>Img</span>
              </div>
              <div class="flex-grow">
                <h4 class="text-xs font-semibold text-brand-navy mb-0.5 leading-tight">{{ item.name }}</h4>
                <div class="text-[11px] text-slate-500 mb-2 font-medium">
                  {{ productStore.formatPrice(item.price) }}
                </div>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center border border-slate-200 rounded-md overflow-hidden">
                    <button @click="productStore.updateQuantity(item.id, item.quantity - 1)" class="w-6 h-6 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition" :disabled="item.quantity <= 1">
                      <Minus class="w-2.5 h-2.5" />
                    </button>
                    <div class="w-6 text-center text-[11px] font-semibold">{{ item.quantity }}</div>
                    <button @click="productStore.updateQuantity(item.id, item.quantity + 1)" class="w-6 h-6 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                      <Plus class="w-2.5 h-2.5" />
                    </button>
                  </div>
                  <button @click="productStore.removeFromCart(item.id)" class="text-red-400 hover:text-red-600 p-1 transition">
                    <Trash2 class="w-3.5 h-3.5" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="productStore.cart.length > 0" class="p-6 border-t border-slate-100 bg-slate-50">
          <div class="flex items-center justify-between mb-4">
            <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">Currency</span>
            <div class="flex items-center bg-slate-200 rounded-lg p-0.5 border border-slate-300">
              <button 
                @click="productStore.selectedCurrency = 'USD'"
                class="px-2.5 py-1 text-[11px] font-bold rounded-md transition-all"
                :class="productStore.selectedCurrency === 'USD' ? 'bg-white text-brand-navy shadow-sm' : 'text-slate-500 hover:text-slate-700'"
              >USD</button>
              <button 
                @click="productStore.selectedCurrency = 'KES'"
                class="px-2.5 py-1 text-[11px] font-bold rounded-md transition-all"
                :class="productStore.selectedCurrency === 'KES' ? 'bg-white text-brand-navy shadow-sm' : 'text-slate-500 hover:text-slate-700'"
              >KSH</button>
            </div>
          </div>
          <div class="flex justify-between items-center mb-5">
            <span class="text-sm text-slate-600 font-medium">Estimated Total</span>
            <span class="text-xl font-bold text-brand-navy">{{ productStore.formattedCartTotal }}</span>
          </div>
          
          <Link 
            :href="route('checkout')" 
            @click="productStore.isCartOpen = false"
            class="w-full bg-brand-indigo hover:bg-brand-hover text-white py-3 rounded-lg font-bold text-sm shadow-md shadow-brand-indigo/30 transition-all flex items-center justify-center gap-2"
          >
            {{ productStore.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000) ? 'Request a Quote' : 'Proceed to Checkout' }}
            <ArrowRight class="w-4 h-4" />
          </Link>
          <div v-if="productStore.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000)" class="text-center mt-3 text-[10px] text-slate-500 font-medium uppercase tracking-wide">
            Over online limit. Quote required.
          </div>
        </div>
      </div>
    </div>

  </div>
</template>