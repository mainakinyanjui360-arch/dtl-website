<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Package, LayoutGrid, LogOut, Layers, Wrench, Briefcase, Settings as SettingsIcon, MessageSquare, MessageCircle, CheckCircle, XCircle, Info, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const page = usePage();
const currentUrl = computed(() => page.url);

const showFlash = ref(false);
const flashMessage = ref('');
const flashType = ref('success'); // 'success', 'error', 'info'

watch(() => page.props.flash, (flash) => {
  if (flash?.success) {
    flashMessage.value = flash.success;
    flashType.value = 'success';
    showFlash.value = true;
  } else if (flash?.error) {
    flashMessage.value = flash.error;
    flashType.value = 'error';
    showFlash.value = true;
  } else if (flash?.message) {
    flashMessage.value = flash.message;
    flashType.value = 'info';
    showFlash.value = true;
  }
  
  if (showFlash.value) {
    setTimeout(() => {
      showFlash.value = false;
    }, 5000);
  }
}, { deep: true, immediate: true });

const closeFlash = () => {
  showFlash.value = false;
};
</script>

<template>
  <div class="min-h-screen bg-slate-50 flex">
    
    <!-- Sidebar -->
    <div class="w-72 bg-[#0B1120] border-r border-slate-800 text-slate-300 flex flex-col shrink-0 hidden md:flex shadow-2xl relative z-20">
      <div class="p-6">
        <Link href="/">
          <img src="/images/dtl-logo-preview.png" alt="DTL" class="h-10 bg-white p-1 rounded mb-8" />
        </Link>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Administration</h2>
        <nav class="space-y-2">
          <Link href="/shop/admin/products" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/products') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <Package class="w-5 h-5" />
            Products
          </Link>
          <Link href="/shop/admin/taxonomy" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/taxonomy') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <LayoutGrid class="w-5 h-5" />
            Categories & Tags
          </Link>
          <Link href="/shop/admin/procurement-cards" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/procurement-cards') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <Layers class="w-5 h-5" />
            Procurement Cards
          </Link>
          <Link href="/shop/admin/services" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/services') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <Wrench class="w-5 h-5" />
            Services
          </Link>
          <Link href="/shop/admin/projects" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/projects') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <Briefcase class="w-5 h-5" />
            Projects
          </Link>
          <Link href="/shop/admin/quotes" class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/quotes') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <div class="flex items-center gap-3">
              <MessageSquare class="w-5 h-5" />
              Quote Requests
            </div>
            <span v-if="$page.props.pendingQuotesCount > 0" class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
              {{ $page.props.pendingQuotesCount }}
            </span>
          </Link>
          <Link href="/shop/admin/inquiries" class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/inquiries') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <div class="flex items-center gap-3">
              <MessageCircle class="w-5 h-5" />
              Inquiries
            </div>
            <span v-if="$page.props.pendingInquiriesCount > 0" class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
              {{ $page.props.pendingInquiriesCount }}
            </span>
          </Link>
          <Link href="/shop/admin/settings" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
            :class="currentUrl.startsWith('/shop/admin/settings') ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white'">
            <SettingsIcon class="w-5 h-5" />
            Settings
          </Link>
        </nav>
      </div>
      <div class="mt-auto p-6 border-t border-slate-800">
        <Link href="/shop/logout" method="post" as="button" class="flex items-center gap-3 text-slate-400 hover:text-white transition w-full text-left">
          <LogOut class="w-5 h-5" />
          Sign Out
        </Link>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 h-screen bg-slate-50">
      
      <!-- Top Header Bar -->
      <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0 shadow-sm z-10">
        <div class="flex items-center gap-4">
          <h1 class="text-xl font-bold text-brand-navy">DTL Admin Center</h1>
          <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brand-indigo/10 text-brand-indigo border border-brand-indigo/20 uppercase tracking-wider">Production</span>
        </div>
        <div class="flex items-center gap-4">
          <a href="/" target="_blank" class="text-sm font-medium text-slate-500 hover:text-brand-indigo transition flex items-center gap-1.5">
            View Live Site
          </a>
          <div class="w-px h-6 bg-slate-200 mx-2"></div>
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-brand-indigo text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
              AD
            </div>
            <span class="text-sm font-bold text-slate-700 hidden md:block">Administrator</span>
          </div>
        </div>
      </header>

      <!-- Scrollable Main Content -->
      <main class="flex-1 overflow-y-auto p-4 md:p-8">
        <slot />
      </main>
    </div>

    <!-- Global Toast Notification -->
    <transition
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showFlash" class="fixed bottom-4 right-4 z-50 max-w-sm w-full bg-white shadow-xl rounded-xl border border-slate-100 overflow-hidden">
        <div class="p-4 flex items-start gap-3">
          <div class="shrink-0 mt-0.5">
            <CheckCircle v-if="flashType === 'success'" class="w-5 h-5 text-emerald-500" />
            <XCircle v-else-if="flashType === 'error'" class="w-5 h-5 text-red-500" />
            <Info v-else class="w-5 h-5 text-brand-indigo" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-800">
              {{ flashType === 'success' ? 'Success' : flashType === 'error' ? 'Error' : 'Notification' }}
            </p>
            <p class="text-sm text-slate-500 mt-1">{{ flashMessage }}</p>
          </div>
          <button @click="closeFlash" class="shrink-0 text-slate-400 hover:text-slate-600 transition-colors">
            <X class="w-4 h-4" />
          </button>
        </div>
      </div>
    </transition>

  </div>
</template>
