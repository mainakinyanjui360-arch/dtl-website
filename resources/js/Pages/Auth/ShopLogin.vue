<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Lock, Mail, ArrowRight } from 'lucide-vue-next';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/shop/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Staff Login - Dignity Traders" />

  <div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Decorative Backgrounds -->
    <div class="absolute inset-0 z-0">
      <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-brand-indigo/10 blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
    </div>

    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="flex justify-center mb-6">
        <Link href="/">
          <img src="/images/dtl-logo-preview.png" alt="Dignity Traders Ltd" class="h-16 w-auto object-contain" />
        </Link>
      </div>
      <h2 class="mt-2 text-center text-3xl font-extrabold text-brand-navy tracking-tight">
        Staff Portal
      </h2>
      <p class="mt-2 text-center text-sm text-slate-500">
        Sign in to manage the Enterprise Hardware Shop
      </p>
    </div>

    <div class="relative z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-10 px-4 shadow-xl shadow-slate-200/50 sm:rounded-2xl sm:px-10 border border-slate-100">
        
        <div v-if="form.errors.email" class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm font-medium">
          {{ form.errors.email }}
        </div>

        <form class="space-y-6" @submit.prevent="submit">
          <div>
            <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
            <div class="mt-2 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Mail class="h-5 w-5 text-slate-400" />
              </div>
              <input id="email" v-model="form.email" type="email" autocomplete="email" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-indigo/20 focus:border-brand-indigo sm:text-sm transition-shadow bg-slate-50 focus:bg-white" placeholder="admin@dignityafrica.co.ke">
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
            <div class="mt-2 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Lock class="h-5 w-5 text-slate-400" />
              </div>
              <input id="password" v-model="form.password" type="password" autocomplete="current-password" required class="appearance-none block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-indigo/20 focus:border-brand-indigo sm:text-sm transition-shadow bg-slate-50 focus:bg-white" placeholder="••••••••">
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input id="remember-me" v-model="form.remember" type="checkbox" class="h-4 w-4 text-brand-indigo focus:ring-brand-indigo border-slate-300 rounded cursor-pointer">
              <label for="remember-me" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                Remember me
              </label>
            </div>
          </div>

          <div>
            <button type="submit" :disabled="form.processing" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-brand-indigo/30 text-sm font-bold text-white bg-brand-indigo hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-indigo transition-all disabled:opacity-50 disabled:cursor-not-allowed">
              <span v-if="form.processing">Authenticating...</span>
              <span v-else class="flex items-center gap-2">Sign In <ArrowRight class="w-4 h-4" /></span>
            </button>
          </div>
        </form>
      </div>
      
      <div class="mt-8 text-center text-xs text-slate-400">
        &copy; {{ new Date().getFullYear() }} Dignity Traders Ltd. All rights reserved.
      </div>
    </div>
  </div>
</template>
