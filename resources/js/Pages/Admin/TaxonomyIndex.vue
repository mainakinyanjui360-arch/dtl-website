<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { Package, Tag as TagIcon, LayoutGrid, Trash2, ArrowLeft } from 'lucide-vue-next';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  categories: Array,
  tags: Array
});

const deleteCategory = (id) => {
  if (confirm('Are you sure you want to delete this category? Any associated products may lose their category link.')) {
    router.delete(`/shop/admin/categories/${id}`, { preserveScroll: true });
  }
};

const deleteTag = (id) => {
  if (confirm('Are you sure you want to delete this tag?')) {
    router.delete(`/shop/admin/tags/${id}`, { preserveScroll: true });
  }
};
</script>

<template>
  <Head title="Manage Categories & Tags - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <!-- Header -->
      <header class="bg-white border-b border-slate-200 px-8 py-6 flex items-center justify-between shrink-0">
        <div>
          <h1 class="text-2xl font-black text-brand-navy">Categories & Tags</h1>
          <p class="text-sm text-slate-500 mt-1">Manage taxonomy for your product catalog.</p>
        </div>
      </header>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto p-8">
      <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Categories -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="p-6 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brand-indigo/10 flex items-center justify-center text-brand-indigo shrink-0">
              <LayoutGrid class="w-5 h-5" />
            </div>
            <div>
              <h2 class="text-lg font-bold text-brand-navy">Categories</h2>
              <p class="text-xs text-slate-500">Add categories when creating products.</p>
            </div>
          </div>
          
          <div class="divide-y divide-slate-100">
            <div v-for="cat in categories" :key="cat.id" class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
              <div>
                <h3 class="font-bold text-slate-800">{{ cat.name }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ cat.products_count }} Products</p>
              </div>
              <button @click="deleteCategory(cat.id)" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
            <div v-if="categories.length === 0" class="p-8 text-center text-slate-500 text-sm">
              No categories found. Create one when adding a product!
            </div>
          </div>
        </div>

        <!-- Tags -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
          <div class="p-6 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
              <TagIcon class="w-5 h-5" />
            </div>
            <div>
              <h2 class="text-lg font-bold text-brand-navy">Tags</h2>
              <p class="text-xs text-slate-500">Add tags when creating products.</p>
            </div>
          </div>
          
          <div class="divide-y divide-slate-100">
            <div v-for="tag in tags" :key="tag.id" class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
              <div>
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-emerald-400 block"></span>
                  {{ tag.name }}
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ tag.products_count }} Products</p>
              </div>
              <button @click="deleteTag(tag.id)" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
            <div v-if="tags.length === 0" class="p-8 text-center text-slate-500 text-sm">
              No tags found. Create one when adding a product!
            </div>
          </div>
        </div>

      </div>
    </div>
    </div>
  </AdminLayout>
</template>
