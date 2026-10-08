<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Package, ArrowLeft, UploadCloud, Save, FileText, X, LayoutGrid, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  product: {
    type: Object,
    required: true
  },
  categories: {
    type: Array,
    default: () => []
  },
  tags: {
    type: Array,
    default: () => []
  }
});

const form = useForm({
  _method: 'put',
  name: props.product.name || '',
  category_id: props.product.category_id || '',
  tags: props.product.tags ? props.product.tags.map(t => t.id) : [],
  description: props.product.description || '',
  specifications: props.product.specifications || '',
  price: props.product.price || '',
  currency: props.product.currency || 'USD',
  stock: props.product.stock !== undefined ? props.product.stock : true,
  images: [], // for new images
});

const existingImages = ref(props.product.images || []);
const previewUrls = ref([]);

// Modals
const showCategoryModal = ref(false);
const newCategoryForm = useForm({ name: '' });

const showTagModal = ref(false);
const newTagForm = useForm({ name: '' });

const saveCategory = () => {
  newCategoryForm.post('/shop/admin/categories', {
    preserveScroll: true,
    onSuccess: () => {
      showCategoryModal.value = false;
      newCategoryForm.reset();
    }
  });
};

const saveTag = () => {
  newTagForm.post('/shop/admin/tags', {
    preserveScroll: true,
    onSuccess: () => {
      showTagModal.value = false;
      newTagForm.reset();
    }
  });
};

const handleFileChange = (e) => {
  const files = Array.from(e.target.files);
  
  files.forEach(file => {
    form.images.push(file);
    previewUrls.value.push(URL.createObjectURL(file));
  });
};

const removeNewImage = (index) => {
  URL.revokeObjectURL(previewUrls.value[index]);
  form.images.splice(index, 1);
  previewUrls.value.splice(index, 1);
};

const submit = () => {
  form.post(`/shop/admin/products/${props.product.id}`, {
    forceFormData: true,
  });
};

const deleteProduct = () => {
  if (confirm('Are you sure you want to delete this product?')) {
    router.delete(`/shop/admin/products/${props.product.id}`);
  }
};
</script>

<template>
  <Head :title="`Edit ${product.name} - Dignity Traders`" />

  <AdminLayout>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <div class="flex items-center gap-4">
          <Link href="/shop/admin/products" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
            <ArrowLeft class="w-4 h-4" />
          </Link>
          <h1 class="text-xl font-bold text-brand-navy">Edit Product: {{ product.name }}</h1>
        </div>
        <button v-if="$page.props.auth.user.is_super_admin || ($page.props.auth.user.permissions && $page.props.auth.user.permissions.includes('delete_products'))" type="button" @click="deleteProduct" class="text-red-500 hover:text-red-600 font-bold text-sm flex items-center gap-2 transition-colors">
          <Trash2 class="w-4 h-4" />
          Delete Product
        </button>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto bg-slate-50">
        <div class="max-w-3xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          
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
                  <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-slate-700">Category</label>
                    <button type="button" @click="showCategoryModal = true" class="text-xs font-bold text-brand-indigo hover:underline">+ Add New</button>
                  </div>
                  <select v-model="form.category_id" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
                    <option value="" disabled>Select a category</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                  </select>
                  <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>
                </div>

                <div class="md:col-span-2">
                  <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-semibold text-slate-700">Tags</label>
                    <button type="button" @click="showTagModal = true" class="text-xs font-bold text-brand-indigo hover:underline">+ Add New Tag</button>
                  </div>
                  <div class="flex flex-wrap gap-2 p-2 border border-slate-200 rounded-lg min-h-[46px] items-center bg-white">
                    <label v-for="tag in tags" :key="tag.id" class="cursor-pointer flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-colors"
                      :class="form.tags.includes(tag.id) ? 'bg-brand-indigo text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                      <input type="checkbox" :value="tag.id" v-model="form.tags" class="sr-only" />
                      {{ tag.name }}
                    </label>
                  </div>
                  <div v-if="form.errors.tags" class="text-red-500 text-xs mt-1">{{ form.errors.tags }}</div>
                </div>
              </div>

              <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Short Description</label>
                <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="Write a short summary..."></textarea>
                <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
              </div>

              <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Full Specifications</label>
                <textarea v-model="form.specifications" rows="6" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="Paste technical specs, bullet points, etc."></textarea>
                <p class="text-[10px] text-slate-400 mt-1">You can paste formatted text (lists, line breaks). They will be preserved.</p>
                <div v-if="form.errors.specifications" class="text-red-500 text-xs mt-1">{{ form.errors.specifications }}</div>
              </div>
            </div>

            <!-- Pricing & Inventory -->
            <div>
              <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">Pricing & Inventory</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-3 gap-2">
                  <div class="col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Price</label>
                    <input v-model="form.price" type="number" step="0.01" min="0" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo" placeholder="0.00">
                    <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>
                  </div>
                  <div class="col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Currency</label>
                    <select v-model="form.currency" class="w-full px-2 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
                      <option value="USD">USD</option>
                      <option value="KES">KSH</option>
                    </select>
                    <div v-if="form.errors.currency" class="text-red-500 text-xs mt-1">{{ form.errors.currency }}</div>
                  </div>
                </div>
                
                <div class="flex items-center gap-6">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Availability</label>
                    <div class="flex items-center h-[42px]">
                      <label class="flex items-center gap-2 cursor-pointer">
                        <div class="relative flex items-center">
                          <input v-model="form.stock" type="checkbox" class="sr-only peer">
                          <div class="w-9 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-indigo"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ form.stock ? 'In Stock' : 'Out of Stock' }}</span>
                      </label>
                    </div>
                  </div>
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
                <p class="text-xs text-slate-500">SVG, PNG, JPG or GIF (max. 10MB per file)</p>
              </div>
              <div v-for="(error, key) in form.errors" :key="key">
                <div v-if="key.startsWith('images')" class="text-red-500 text-xs mt-1">{{ error }}</div>
              </div>
              
              <!-- Existing Images -->
              <div v-if="existingImages.length > 0" class="mt-6 mb-2">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Current Images</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                  <div v-for="image in existingImages" :key="image.id" class="relative group aspect-square rounded-lg border border-slate-200 overflow-hidden bg-slate-100">
                    <img :src="image.image_path" class="w-full h-full object-cover" />
                    <div v-if="image.is_primary" class="absolute top-2 left-2 bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm z-10 pointer-events-none">
                      PRIMARY
                    </div>
                  </div>
                </div>
              </div>

              <!-- New Image Previews -->
              <div v-if="previewUrls.length > 0" class="mt-6">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">New Images to Upload</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                  <div v-for="(url, index) in previewUrls" :key="index" class="relative group aspect-square rounded-lg border border-slate-200 overflow-hidden bg-slate-100">
                    <img :src="url" class="w-full h-full object-cover" />
                    
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                      <button type="button" @click.prevent="removeNewImage(index)" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transform scale-90 group-hover:scale-100 transition-all">
                        <X class="w-4 h-4" />
                      </button>
                    </div>

                    <div v-if="index === 0 && existingImages.length === 0" class="absolute top-2 left-2 bg-brand-indigo text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm z-10 pointer-events-none">
                      PRIMARY
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Documents -->
            <div>
              <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">Technical Documents</h3>
              
              <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:bg-slate-50 transition-colors relative flex flex-col items-center justify-center">
                <input type="file" accept="application/pdf" @change="e => form.spec_sheet = e.target.files[0]" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                
                <template v-if="!form.spec_sheet">
                  <FileText class="w-10 h-10 text-brand-indigo mx-auto mb-3" />
                  <p class="text-sm font-semibold text-brand-navy mb-1">Upload Specification Sheet</p>
                  <p class="text-xs text-slate-500">PDF document only (max. 10MB)</p>
                </template>
                <template v-else>
                  <FileText class="w-10 h-10 text-emerald-500 mx-auto mb-3" />
                  <p class="text-sm font-semibold text-emerald-700 mb-1">Selected: {{ form.spec_sheet.name }}</p>
                  <p class="text-xs text-slate-500 cursor-pointer z-20 relative hover:text-brand-indigo" @click.stop="form.spec_sheet = null">Remove file</p>
                </template>
              </div>
              <div v-if="form.errors.spec_sheet" class="text-red-500 text-xs mt-1">{{ form.errors.spec_sheet }}</div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
              <button 
                type="submit" 
                :disabled="form.processing" 
                class="bg-brand-indigo hover:bg-brand-hover text-white px-8 py-3 rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-brand-indigo/30 transition-all disabled:opacity-50"
              >
                <Save class="w-4 h-4" />
                <span v-if="form.processing">Updating...</span>
                <span v-else>Update Product</span>
              </button>
            </div>
          </form>
          
        </div>
      </main>
    </div>

    <!-- Category Modal -->
    <div v-if="showCategoryModal" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCategoryModal = false"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative z-10">
        <h3 class="text-xl font-bold text-brand-navy mb-4">Add New Category</h3>
        <form @submit.prevent="saveCategory">
          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Category Name</label>
            <input v-model="newCategoryForm.name" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            <div v-if="newCategoryForm.errors.name" class="text-red-500 text-xs mt-1">{{ newCategoryForm.errors.name }}</div>
          </div>
          <div class="flex justify-end gap-3">
            <button type="button" @click="showCategoryModal = false" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100">Cancel</button>
            <button type="submit" :disabled="newCategoryForm.processing" class="px-4 py-2 rounded-lg font-bold text-sm text-white bg-brand-indigo hover:bg-brand-hover disabled:opacity-50">Save</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tag Modal -->
    <div v-if="showTagModal" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center">
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showTagModal = false"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative z-10">
        <h3 class="text-xl font-bold text-brand-navy mb-4">Add New Tag</h3>
        <form @submit.prevent="saveTag">
          <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tag Name</label>
            <input v-model="newTagForm.name" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
            <div v-if="newTagForm.errors.name" class="text-red-500 text-xs mt-1">{{ newTagForm.errors.name }}</div>
          </div>
          <div class="flex justify-end gap-3">
            <button type="button" @click="showTagModal = false" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100">Cancel</button>
            <button type="submit" :disabled="newTagForm.processing" class="px-4 py-2 rounded-lg font-bold text-sm text-white bg-brand-indigo hover:bg-brand-hover disabled:opacity-50">Save</button>
          </div>
        </form>
      </div>
    </div>

  </AdminLayout>
</template>
