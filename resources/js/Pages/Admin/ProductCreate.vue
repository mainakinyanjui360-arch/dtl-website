<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Package, ArrowLeft, UploadCloud, Save } from 'lucide-vue-next';

defineProps({
  categories: {
    type: Array,
    default: () => []
  }
});

const form = useForm({
  name: '',
  category_id: '',
  description: '',
  price: '',
  stock: true,
  images: []
});

const previewUrls = ref([]);

const handleFileChange = (e) => {
  const files = Array.from(e.target.files);
  form.images = files;
  
  // Create preview URLs
  previewUrls.value.forEach(url => URL.revokeObjectURL(url));
  previewUrls.value = files.map(file => URL.createObjectURL(file));
};

const submit = () => {
  form.post('/shop/admin/products', {
    forceFormData: true,
  });
};
</script>

<template>
  <Head title="Add Product - Dignity Traders" />

  <div class="min-h-screen bg-slate-50 flex">
    
    <!-- Sidebar (Simplified for subpage) -->
    <div class="w-64 bg-brand-navy text-white flex flex-col shrink-0 hidden md:flex">
      <div class="p-6">
        <Link href="/">
          <img src="/images/dtl-logo-preview.png" alt="DTL" class="h-10 bg-white p-1 rounded mb-8" />
        </Link>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Administration</h2>
        <nav class="space-y-2">
          <Link href="/shop/admin/products" class="flex items-center gap-3 px-4 py-3 bg-brand-indigo/20 text-brand-indigo font-bold rounded-lg border border-brand-indigo/30 transition-colors">
            <Package class="w-5 h-5" />
            Products
          </Link>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <div class="flex items-center gap-4">
          <Link href="/shop/admin/products" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
            <ArrowLeft class="w-4 h-4" />
          </Link>
          <h1 class="text-xl font-bold text-brand-navy">Add New Product</h1>
        </div>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div class="max-w-4xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          
          <form @submit.prevent="submit" class="p-8 space-y-8">
            <!-- Basic Info -->
            <div>
              <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">Basic Information</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Product Name</label>
                  <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="e.g., Cisco Catalyst 9300">
                  <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                </div>
                
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Category</label>
                  <select v-model="form.category_id" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
                    <option value="" disabled>Select a category</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                  </select>
                  <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>
                </div>
              </div>

              <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                <textarea v-model="form.description" rows="4" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="Write a detailed product description..."></textarea>
                <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
              </div>
            </div>

            <!-- Pricing & Inventory -->
            <div>
              <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">Pricing & Inventory</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Price (USD)</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-slate-400">$</span>
                    </div>
                    <input v-model="form.price" type="number" step="0.01" min="0" required class="w-full pl-8 pr-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="0.00">
                  </div>
                  <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>
                </div>
                
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-1">Availability</label>
                  <div class="flex items-center h-[42px]">
                    <label class="flex items-center gap-3 cursor-pointer">
                      <div class="relative flex items-center">
                        <input v-model="form.stock" type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-indigo/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-indigo"></div>
                      </div>
                      <span class="text-sm font-medium text-slate-700">{{ form.stock ? 'In Stock' : 'Out of Stock' }}</span>
                    </label>
                  </div>
                  <div v-if="form.errors.stock" class="text-red-500 text-xs mt-1">{{ form.errors.stock }}</div>
                </div>
              </div>
            </div>

            <!-- Images -->
            <div>
              <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">Product Images</h3>
              
              <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:bg-slate-50 transition-colors relative">
                <input type="file" multiple accept="image/*" @change="handleFileChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                <UploadCloud class="w-10 h-10 text-brand-indigo mx-auto mb-3" />
                <p class="text-sm font-semibold text-brand-navy mb-1">Click to upload or drag and drop</p>
                <p class="text-xs text-slate-500">SVG, PNG, JPG or GIF (max. 2MB per file)</p>
              </div>
              <div v-if="form.errors['images.*']" class="text-red-500 text-xs mt-1">{{ form.errors['images.*'] }}</div>
              
              <!-- Image Previews -->
              <div v-if="previewUrls.length > 0" class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div v-for="(url, index) in previewUrls" :key="index" class="relative group aspect-square rounded-lg border border-slate-200 overflow-hidden bg-slate-100">
                  <img :src="url" class="w-full h-full object-cover" />
                  <div v-if="index === 0" class="absolute top-2 left-2 bg-brand-indigo text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                    PRIMARY
                  </div>
                </div>
              </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
              <button 
                type="submit" 
                :disabled="form.processing" 
                class="bg-brand-indigo hover:bg-brand-hover text-white px-8 py-3 rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-brand-indigo/30 transition-all disabled:opacity-50"
              >
                <Save class="w-4 h-4" />
                <span v-if="form.processing">Saving...</span>
                <span v-else>Save Product</span>
              </button>
            </div>
          </form>
          
        </div>
      </main>
    </div>

  </div>
</template>
