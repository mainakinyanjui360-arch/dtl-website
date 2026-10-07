<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Briefcase, Plus, Trash2, Edit, CheckCircle, XCircle, Image as ImageIcon } from 'lucide-vue-next';

defineProps({
  projects: {
    type: Array,
    required: true
  }
});

const showCreateModal = ref(false);
const editingProject = ref(null);
const imagePreview = ref(null);

const form = useForm({
  title: '',
  client: '',
  description: '',
  category: '',
  completion_date: '',
  image: null,
  is_active: true,
  sort_order: 0
});

const handleImageUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.image = file;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const openCreateModal = () => {
  editingProject.value = null;
  form.reset();
  imagePreview.value = null;
  showCreateModal.value = true;
};

const editProject = (project) => {
  editingProject.value = project;
  form.title = project.title;
  form.client = project.client || '';
  form.description = project.description;
  form.category = project.category || '';
  form.completion_date = project.completion_date || '';
  form.image = null; // Will only upload if changed
  form.is_active = project.is_active;
  form.sort_order = project.sort_order;
  imagePreview.value = project.image ? project.image : null;
  showCreateModal.value = true;
};

const submit = () => {
  const url = editingProject.value 
    ? `/shop/admin/projects/${editingProject.value.id}` 
    : '/shop/admin/projects';

  form.post(url, {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      showCreateModal.value = false;
      form.reset();
      editingProject.value = null;
      imagePreview.value = null;
    }
  });
};

const deleteForm = useForm({});
const deleteProject = (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    deleteForm.delete(`/shop/admin/projects/${id}`, {
      preserveScroll: true
    });
  }
};
</script>

<template>
  <Head title="Projects Management - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy flex items-center gap-2">
          <Briefcase class="w-6 h-6 text-slate-400" />
          Projects Portfolio
        </h1>
        <button @click="openCreateModal" class="bg-brand-indigo hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
          <Plus class="w-4 h-4" />
          Add Project
        </button>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="projects.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <Briefcase class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Projects Yet</h3>
          <p class="text-slate-500 mb-6 max-w-md mx-auto">Add completed projects to showcase your portfolio to potential clients.</p>
          <button @click="openCreateModal" class="inline-block bg-brand-navy hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-bold text-sm transition-colors">Add Project</button>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                <th class="p-4 font-semibold w-24 text-center">Image</th>
                <th class="p-4 font-semibold">Title & Details</th>
                <th class="p-4 font-semibold">Client</th>
                <th class="p-4 font-semibold text-center">Order</th>
                <th class="p-4 font-semibold text-center">Status</th>
                <th class="p-4 font-semibold text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="project in projects" :key="project.id" class="hover:bg-slate-50 transition-colors">
                <td class="p-4">
                  <div class="w-16 h-12 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 flex items-center justify-center">
                    <img v-if="project.image" :src="project.image" class="w-full h-full object-cover">
                    <ImageIcon v-else class="w-5 h-5 text-slate-400" />
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-brand-navy">{{ project.title }}</div>
                  <div class="text-xs text-brand-indigo mt-1">{{ project.category || 'Uncategorized' }}</div>
                </td>
                <td class="p-4">
                  <div class="text-sm font-medium text-slate-700">
                    {{ project.client || '-' }}
                  </div>
                  <div class="text-xs text-slate-400 mt-1" v-if="project.completion_date">
                    Completed: {{ new Date(project.completion_date).toLocaleDateString() }}
                  </div>
                </td>
                <td class="p-4 text-center font-bold text-slate-500">{{ project.sort_order }}</td>
                <td class="p-4 text-center">
                  <span v-if="project.is_active" class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-bold">
                    <CheckCircle class="w-3 h-3" /> Active
                  </span>
                  <span v-else class="inline-flex items-center gap-1 text-slate-500 bg-slate-100 px-2 py-1 rounded-md text-xs font-bold">
                    <XCircle class="w-3 h-3" /> Hidden
                  </span>
                </td>
                <td class="p-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button @click="editProject(project)" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" title="Edit Project">
                      <Edit class="w-4 h-4" />
                    </button>
                    <button @click="deleteProject(project.id)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Delete Project">
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
          {{ editingProject ? 'Edit Project' : 'Add New Project' }}
        </h3>
        
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Project Title</label>
              <input v-model="form.title" type="text" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Client Name (Optional)</label>
              <input v-model="form.client" type="text" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
            <textarea v-model="form.description" required rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Category / Type</label>
              <input v-model="form.category" type="text" placeholder="e.g. Structured Cabling" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Completion Date</label>
              <input v-model="form.completion_date" type="date" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            </div>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Project Image</label>
            <div class="flex items-center gap-4">
              <div v-if="imagePreview" class="w-32 h-24 rounded-lg border border-slate-200 overflow-hidden shrink-0">
                <img :src="imagePreview" class="w-full h-full object-cover">
              </div>
              <div v-else class="w-32 h-24 rounded-lg border border-dashed border-slate-300 bg-slate-50 flex items-center justify-center shrink-0">
                <ImageIcon class="w-8 h-8 text-slate-300" />
              </div>
              
              <div class="flex-1">
                <input 
                  type="file" 
                  accept="image/*"
                  @change="handleImageUpload"
                  class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-brand-indigo
                    hover:file:bg-indigo-100
                  "/>
                <p class="text-xs text-slate-500 mt-2">Recommended size: 800x600px. Max 2MB.</p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
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
              <span v-else>Save Project</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
