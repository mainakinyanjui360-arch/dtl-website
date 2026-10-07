<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Package, Plus, LogOut, CheckCircle, XCircle, LayoutGrid, Upload, Download, FileText, SquarePen } from 'lucide-vue-next';

defineProps({
  products: {
    type: Array,
    default: () => []
  }
});

const showImportModal = ref(false);

const importForm = useForm({
  csv_file: null
});

const handleImport = () => {
  importForm.post('/shop/admin/products/import', {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      showImportModal.value = false;
      importForm.reset();
      alert('Products imported successfully!');
    }
  });
};
</script>

<template>
  <Head title="Admin Dashboard - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy">Product Management</h1>
        <div class="flex items-center gap-3">
          <button @click="showImportModal = true" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
            <Upload class="w-4 h-4" />
            Import Products
          </button>
          <Link href="/shop/admin/products/create" class="bg-brand-indigo hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
            <Plus class="w-4 h-4" />
            Add Product
          </Link>
        </div>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="products.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <Package class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Products Yet</h3>
          <p class="text-slate-500 mb-6 max-w-md mx-auto">Get started by adding your first enterprise hardware product to the catalog.</p>
          <Link href="/shop/admin/products/create" class="inline-block bg-brand-navy hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-bold text-sm transition-colors">Create First Product</Link>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
          <!-- Table Toolbar -->
          <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <div class="relative w-full sm:w-72">
              <span class="absolute left-3 top-2.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              </span>
              <input type="text" placeholder="Search products..." class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo bg-white">
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
              <button class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter
              </button>
            </div>
          </div>

          <div class="overflow-x-auto min-w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                  <th class="px-6 py-4 font-semibold w-12 text-center sticky left-0 z-10 bg-slate-50">
                    <input type="checkbox" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo cursor-pointer">
                  </th>
                  <th class="px-6 py-4 font-semibold w-20">Image</th>
                  <th class="px-6 py-4 font-semibold min-w-[250px]">Name</th>
                  <th class="px-6 py-4 font-semibold">Category</th>
                  <th class="px-6 py-4 font-semibold">Price</th>
                  <th class="px-6 py-4 font-semibold">Status</th>
                  <th class="px-6 py-4 font-semibold text-right sticky right-0 z-10 bg-slate-50">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr v-for="product in products" :key="product.id" @click="$inertia.get(`/shop/admin/products/${product.id}/edit`)" class="hover:bg-slate-50/80 transition-colors cursor-pointer group">
                  <td class="px-6 py-4 text-center sticky left-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors" @click.stop>
                    <input type="checkbox" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo cursor-pointer">
                  </td>
                  <td class="px-6 py-4">
                    <div v-if="product.images && product.images.length > 0" class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden shadow-sm">
                      <img :src="product.images.find(img => img.is_primary)?.image_path || product.images[0].image_path" class="w-full h-full object-cover" />
                    </div>
                    <div v-else class="w-12 h-12 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-400">IMG</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-brand-navy truncate max-w-[300px]">{{ product.name }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ product.category?.name }}</td>
                  <td class="px-6 py-4 font-bold text-slate-700">{{ product.currency === 'KES' ? 'KSH' : '$' }}{{ parseFloat(product.price).toFixed(2) }}</td>
                  <td class="px-6 py-4 text-sm font-semibold">
                    <span v-if="product.stock" class="inline-flex items-center gap-1.5 text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs border border-emerald-100">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> In Stock
                    </span>
                    <span v-else class="inline-flex items-center gap-1.5 text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md text-xs border border-slate-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Out of Stock
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right sticky right-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors">
                    <button type="button" class="text-slate-400 hover:text-brand-indigo transition-colors p-2 rounded-lg hover:bg-slate-100 bg-white shadow-sm border border-slate-200 group-hover:border-indigo-200">
                      <SquarePen class="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination Footer -->
          <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between text-sm text-slate-500">
            <div>Showing <span class="font-bold text-slate-700">{{ products.length }}</span> items</div>
            <div class="flex gap-1">
              <button class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">Prev</button>
              <button class="px-3 py-1 rounded border border-slate-200 bg-white hover:bg-slate-50 text-brand-navy font-medium">Next</button>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Import Modal -->
    <div v-if="showImportModal" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showImportModal = false"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative z-10">
        <h3 class="text-xl font-bold text-brand-navy mb-4">Bulk Import Products</h3>
        
        <p class="text-sm text-slate-600 mb-6">
          Upload a CSV file to bulk import products. 
          <a href="/shop/admin/products/template" class="text-brand-indigo font-bold hover:underline inline-flex items-center gap-1">
            <Download class="w-4 h-4" /> Download Template
          </a>
        </p>

        <form @submit.prevent="handleImport">
          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">CSV File</label>
            <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition-colors relative flex flex-col items-center justify-center">
              <input type="file" accept=".csv" @change="e => importForm.csv_file = e.target.files[0]" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
              
              <template v-if="!importForm.csv_file">
                <FileText class="w-8 h-8 text-slate-400 mx-auto mb-2" />
                <p class="text-sm font-semibold text-brand-navy mb-1">Click or drag CSV here</p>
              </template>
              <template v-else>
                <FileText class="w-8 h-8 text-brand-indigo mx-auto mb-2" />
                <p class="text-sm font-semibold text-brand-indigo mb-1">{{ importForm.csv_file.name }}</p>
              </template>
            </div>
            <div v-if="importForm.errors.csv_file" class="text-red-500 text-xs mt-1">{{ importForm.errors.csv_file }}</div>
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" @click="showImportModal = false" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100">Cancel</button>
            <button type="submit" :disabled="importForm.processing || !importForm.csv_file" class="px-4 py-2 rounded-lg font-bold text-sm text-white bg-brand-indigo hover:bg-brand-hover disabled:opacity-50 flex items-center gap-2">
              <Upload class="w-4 h-4" />
              <span v-if="importForm.processing">Importing...</span>
              <span v-else>Import</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
