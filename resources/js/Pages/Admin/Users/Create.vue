<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeft, Save } from 'lucide-vue-next';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  is_super_admin: false,
  permissions: [],
});

const submit = () => {
  form.post(route('admin.users.store'));
};
</script>

<template>
  <Head title="Create Admin" />

  <AdminLayout>
    <div class="mb-6">
      <Link :href="route('admin.users.index')" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-brand-indigo mb-2 transition-colors">
        <ArrowLeft class="w-4 h-4" />
        Back to Team
      </Link>
      <h1 class="text-2xl font-bold text-brand-navy">Create New Admin</h1>
      <p class="text-sm text-slate-500 mt-1">Add a new user to the dashboard.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm max-w-2xl">
      <form @submit.prevent="submit" class="p-6 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name *</label>
            <input 
              v-model="form.name" 
              type="text" 
              required
              class="w-full text-sm rounded-lg border border-slate-200 px-3 py-2.5 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
            />
            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address *</label>
            <input 
              v-model="form.email" 
              type="email" 
              required
              class="w-full text-sm rounded-lg border border-slate-200 px-3 py-2.5 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
            />
            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Password *</label>
            <input 
              v-model="form.password" 
              type="password" 
              required
              class="w-full text-sm rounded-lg border border-slate-200 px-3 py-2.5 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
            />
            <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Confirm Password *</label>
            <input 
              v-model="form.password_confirmation" 
              type="password" 
              required
              class="w-full text-sm rounded-lg border border-slate-200 px-3 py-2.5 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
            />
          </div>
        </div>

        <div class="border-t border-slate-100 pt-6">
          <label class="flex items-center gap-3 cursor-pointer">
            <input 
              type="checkbox" 
              v-model="form.is_super_admin"
              class="w-5 h-5 rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo"
            />
            <div>
              <span class="block text-sm font-semibold text-brand-navy">Super Admin Privilege</span>
              <span class="block text-xs text-slate-500">Super admins have full access, can manage users, and bypass all permission checks.</span>
            </div>
          </label>
        </div>

        <div v-if="!form.is_super_admin" class="border-t border-slate-100 pt-6">
          <h3 class="text-sm font-semibold text-brand-navy mb-4">Specific Permissions</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="manage_settings" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Manage Global Settings</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="delete_products" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Delete Products</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="delete_taxonomy" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Delete Categories/Tags</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="delete_projects" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Delete Projects</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="delete_services" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Delete Services</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.permissions" value="delete_quotes" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo" />
              <span class="text-sm text-slate-700">Delete Quotes/Inquiries</span>
            </label>
          </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
          <button 
            type="submit" 
            :disabled="form.processing"
            class="flex items-center gap-2 bg-brand-indigo text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-brand-hover transition-colors shadow-sm disabled:opacity-50"
          >
            <Save class="w-4 h-4" />
            {{ form.processing ? 'Saving...' : 'Create Admin' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
