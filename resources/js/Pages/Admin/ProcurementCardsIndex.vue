<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Layers, Plus, Trash2, Edit, CheckCircle, XCircle } from 'lucide-vue-next';

defineProps({
  cards: {
    type: Array,
    required: true
  }
});

const showCreateModal = ref(false);
const editingCard = ref(null);

const form = useForm({
  title: '',
  tagline: '',
  description: '',
  brands: '',
  image: null,
  is_active: true,
  sort_order: 0
});

const openCreateModal = () => {
  editingCard.value = null;
  form.reset();
  showCreateModal.value = true;
};

const editCard = (card) => {
  editingCard.value = card;
  form.title = card.title;
  form.tagline = card.tagline;
  form.description = card.description;
  form.brands = card.brands ? card.brands.join(', ') : '';
  form.image = null;
  form.is_active = card.is_active;
  form.sort_order = card.sort_order;
  showCreateModal.value = true;
};

const submit = () => {
  const url = editingCard.value 
    ? `/shop/admin/procurement-cards/${editingCard.value.id}` 
    : '/shop/admin/procurement-cards';

  form.post(url, {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      showCreateModal.value = false;
      form.reset();
      editingCard.value = null;
    }
  });
};

const deleteForm = useForm({});
const deleteCard = (id) => {
  if (confirm('Are you sure you want to delete this card?')) {
    deleteForm.delete(`/shop/admin/procurement-cards/${id}`, {
      preserveScroll: true
    });
  }
};
</script>

<template>
  <Head title="Procurement Cards - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy">Procurement & Distribution Cards</h1>
        <button @click="openCreateModal" class="bg-brand-indigo hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
          <Plus class="w-4 h-4" />
          Add Card
        </button>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="cards.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <Layers class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Cards Yet</h3>
          <p class="text-slate-500 mb-6 max-w-md mx-auto">Create a card to display in the Procurement section on the Home page.</p>
          <button @click="openCreateModal" class="inline-block bg-brand-navy hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-bold text-sm transition-colors">Add Card</button>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                <th class="p-4 font-semibold w-16">Image</th>
                <th class="p-4 font-semibold">Title & Tagline</th>
                <th class="p-4 font-semibold">Brands</th>
                <th class="p-4 font-semibold text-center">Order</th>
                <th class="p-4 font-semibold text-center">Status</th>
                <th class="p-4 font-semibold text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="card in cards" :key="card.id" class="hover:bg-slate-50 transition-colors">
                <td class="p-4">
                  <div class="w-16 h-16 rounded bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200">
                    <img v-if="card.image" :src="card.image" class="w-full h-full object-cover" />
                    <span v-else class="text-xs text-slate-400">No Img</span>
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-brand-navy">{{ card.title }}</div>
                  <div class="text-xs text-brand-indigo mt-1">{{ card.tagline }}</div>
                </td>
                <td class="p-4">
                  <div class="text-xs text-slate-500 max-w-xs truncate">
                    {{ card.brands ? card.brands.join(', ') : '-' }}
                  </div>
                </td>
                <td class="p-4 text-center font-bold text-slate-500">{{ card.sort_order }}</td>
                <td class="p-4 text-center">
                  <span v-if="card.is_active" class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-bold">
                    <CheckCircle class="w-3 h-3" /> Active
                  </span>
                  <span v-else class="inline-flex items-center gap-1 text-slate-500 bg-slate-100 px-2 py-1 rounded-md text-xs font-bold">
                    <XCircle class="w-3 h-3" /> Hidden
                  </span>
                </td>
                <td class="p-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button @click="editCard(card)" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit Card">
                      <Edit class="w-4 h-4" />
                    </button>
                    <button @click="deleteCard(card.id)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Delete Card">
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

    <!-- Create Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative z-10 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-brand-navy mb-6 border-b border-slate-100 pb-4">
          {{ editingCard ? 'Edit Procurement Card' : 'Add New Procurement Card' }}
        </h3>
        
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Title</label>
              <input v-model="form.title" type="text" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
              <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Tagline</label>
              <input v-model="form.tagline" type="text" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
              <div v-if="form.errors.tagline" class="text-red-500 text-xs mt-1">{{ form.errors.tagline }}</div>
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
            <textarea v-model="form.description" required rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"></textarea>
            <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Brands (Comma separated)</label>
            <input v-model="form.brands" type="text" placeholder="e.g. HP, Dell, Cisco" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            <div v-if="form.errors.brands" class="text-red-500 text-xs mt-1">{{ form.errors.brands }}</div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-1">Image</label>
              <input type="file" @change="e => form.image = e.target.files[0]" accept="image/*" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-sm">
              <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Sort Order</label>
              <input v-model="form.sort_order" type="number" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
          </div>

          <div class="flex items-center gap-2 mb-6 bg-slate-50 p-3 rounded-lg border border-slate-100">
            <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded text-brand-indigo focus:ring-brand-indigo">
            <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">Visible on Homepage</label>
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100">Cancel</button>
            <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-lg font-bold text-sm text-white bg-brand-indigo hover:bg-brand-hover disabled:opacity-50">
              <span v-if="form.processing">Saving...</span>
              <span v-else>Save Card</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
