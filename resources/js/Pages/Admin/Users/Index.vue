<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Plus, Edit2, Trash2, Shield, User } from 'lucide-vue-next';

defineProps({
  users: Array
});

const form = useForm({});

const deleteUser = (user) => {
  if (confirm(`Are you sure you want to remove ${user.name}? This cannot be undone.`)) {
    form.delete(route('admin.users.destroy', user.id), {
      preserveScroll: true
    });
  }
};
</script>

<template>
  <Head title="Team & Admins" />

  <AdminLayout>
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-brand-navy">Team & Admins</h1>
        <p class="text-sm text-slate-500 mt-1">Manage administrators who can access the dashboard.</p>
      </div>
      <Link v-if="$page.props.auth.user.is_super_admin" :href="route('admin.users.create')" class="flex items-center gap-2 bg-brand-indigo text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-hover transition-colors shadow-sm">
        <Plus class="w-4 h-4" />
        Add Admin
      </Link>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
            <tr>
              <th class="px-6 py-4 font-semibold">Name</th>
              <th class="px-6 py-4 font-semibold">Email Address</th>
              <th class="px-6 py-4 font-semibold">Role</th>
              <th class="px-6 py-4 font-semibold text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50/50 transition-colors">
              <td class="px-6 py-4">
                <div class="font-medium text-brand-navy">{{ user.name }}</div>
              </td>
              <td class="px-6 py-4 text-slate-500">
                {{ user.email }}
              </td>
              <td class="px-6 py-4">
                <span v-if="user.is_super_admin" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-bold tracking-wide uppercase border border-indigo-100">
                  <Shield class="w-3 h-3" />
                  Super Admin
                </span>
                <span v-else class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold tracking-wide uppercase border border-slate-200">
                  <User class="w-3 h-3" />
                  Admin
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <Link 
                    v-if="$page.props.auth.user.is_super_admin || $page.props.auth.user.id === user.id"
                    :href="route('admin.users.edit', user.id)" 
                    class="p-1.5 text-slate-400 hover:text-brand-indigo hover:bg-indigo-50 rounded-md transition-colors"
                    title="Edit User"
                  >
                    <Edit2 class="w-4 h-4" />
                  </Link>
                  <button 
                    v-if="$page.props.auth.user.is_super_admin && $page.props.auth.user.id !== user.id"
                    @click="deleteUser(user)" 
                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
                    title="Delete User"
                  >
                    <Trash2 class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
