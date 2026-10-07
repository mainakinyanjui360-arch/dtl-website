<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Wrench, Plus, Trash2, Edit, CheckCircle, XCircle } from 'lucide-vue-next';

defineProps({
  services: {
    type: Array,
    required: true
  }
});

const showCreateModal = ref(false);
const editingService = ref(null);

const form = useForm({
  title: '',
  tagline: '',
  description: '',
  icon: 'Wrench',
  highlights: '',
  is_active: true,
  sort_order: 0
});

const openCreateModal = () => {
  editingService.value = null;
  form.reset();
  showCreateModal.value = true;
};

const editService = (service) => {
  editingService.value = service;
  form.title = service.title;
  form.tagline = service.tagline;
  form.description = service.description;
  form.icon = service.icon;
  form.highlights = service.highlights ? service.highlights.join(', ') : '';
  form.is_active = service.is_active;
  form.sort_order = service.sort_order;
  showCreateModal.value = true;
};

const submit = () => {
  const url = editingService.value 
    ? `/shop/admin/services/${editingService.value.id}` 
    : '/shop/admin/services';

  form.post(url, {
    preserveScroll: true,
    onSuccess: () => {
      showCreateModal.value = false;
      form.reset();
      editingService.value = null;
    }
  });
};

const deleteForm = useForm({});
const deleteService = (id) => {
  if (confirm('Are you sure you want to delete this service?')) {
    deleteForm.delete(`/shop/admin/services/${id}`, {
      preserveScroll: true
    });
  }
};
</script>

<template>
  <Head title="Services Management - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy">Engineering Capabilities & Services</h1>
        <button @click="openCreateModal" class="bg-brand-indigo hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
          <Plus class="w-4 h-4" />
          Add Service
        </button>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="services.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <Wrench class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Services Yet</h3>
          <p class="text-slate-500 mb-6 max-w-md mx-auto">Create a service to display in the Engineering Capabilities section.</p>
          <button @click="openCreateModal" class="inline-block bg-brand-navy hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-bold text-sm transition-colors">Add Service</button>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                <th class="p-4 font-semibold">Icon</th>
                <th class="p-4 font-semibold">Title & Tagline</th>
                <th class="p-4 font-semibold">Highlights</th>
                <th class="p-4 font-semibold text-center">Order</th>
                <th class="p-4 font-semibold text-center">Status</th>
                <th class="p-4 font-semibold text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="service in services" :key="service.id" class="hover:bg-slate-50 transition-colors">
                <td class="p-4">
                  <div class="text-sm font-bold text-brand-indigo bg-brand-indigo/10 px-2 py-1 rounded inline-block">
                    {{ service.icon }}
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-brand-navy">{{ service.title }}</div>
                  <div class="text-xs text-brand-indigo mt-1">{{ service.tagline }}</div>
                </td>
                <td class="p-4">
                  <div class="text-xs text-slate-500 max-w-xs truncate">
                    {{ service.highlights ? service.highlights.join(', ') : '-' }}
                  </div>
                </td>
                <td class="p-4 text-center font-bold text-slate-500">{{ service.sort_order }}</td>
                <td class="p-4 text-center">
                  <span v-if="service.is_active" class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-bold">
                    <CheckCircle class="w-3 h-3" /> Active
                  </span>
                  <span v-else class="inline-flex items-center gap-1 text-slate-500 bg-slate-100 px-2 py-1 rounded-md text-xs font-bold">
                    <XCircle class="w-3 h-3" /> Hidden
                  </span>
                </td>
                <td class="p-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button @click="editService(service)" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit Service">
                      <Edit class="w-4 h-4" />
                    </button>
                    <button @click="deleteService(service.id)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Delete Service">
                      <Trash2 class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative z-10 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-brand-navy mb-6 border-b border-slate-100 pb-4">
          {{ editingService ? 'Edit Service' : 'Add New Service' }}
        </h3>
        
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
              <input v-model="form.title" type="text" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Tagline</label>
              <input v-model="form.tagline" type="text" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
            <textarea v-model="form.description" required rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"></textarea>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Highlights (Comma separated)</label>
            <input v-model="form.highlights" type="text" placeholder="e.g. Next-Gen firewall, Zero Trust access" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Lucide Icon Name</label>
              <input v-model="form.icon" type="text" required placeholder="e.g. Network, ShieldCheck" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
              <p class="text-xs text-slate-500 mt-1">Uses <a href="https://lucide.dev/icons/" target="_blank" class="text-brand-indigo hover:underline">Lucide Icons</a></p>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Sort Order</label>
              <input v-model="form.sort_order" type="number" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
          </div>

          <div class="flex items-center gap-2 mb-6 bg-slate-50 p-3 rounded-lg border border-slate-100">
            <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded text-brand-indigo focus:ring-brand-indigo">
            <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">Visible to Public</label>
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100">Cancel</button>
            <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-lg font-bold text-sm text-white bg-brand-indigo hover:bg-brand-hover disabled:opacity-50">
              <span v-if="form.processing">Saving...</span>
              <span v-else>Save Service</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
