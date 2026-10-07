<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useProductStore } from '@/Stores/useProductStore';
import { ShoppingCart, ArrowLeft, CheckCircle, XCircle, Plus, Minus, ShieldCheck, Truck, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  product: {
    type: Object,
    required: true
  },
  relatedProducts: {
    type: Array,
    default: () => []
  }
});

const store = useProductStore();

const activeImageIndex = ref(0);
const quantity = ref(1);

const images = computed(() => {
  return props.product.images?.length > 0 
    ? props.product.images 
    : [];
});

const mainImage = computed(() => {
  if (images.value.length === 0) return null;
  return images.value[activeImageIndex.value]?.image_path;
});

const decreaseQty = () => {
  if (quantity.value > 1) quantity.value--;
};

const increaseQty = () => {
  quantity.value++;
};



const handleAddToCart = () => {
  for (let i = 0; i < quantity.value; i++) {
    store.addToCart(props.product);
  }
};
</script>

<template>
  <Head :title="`${product.name} - Shop`" />

  <PublicLayout>
    <!-- Breadcrumbs -->
    <div class="bg-slate-50 border-b border-slate-200 py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <Link href="/shop" class="hover:text-brand-indigo flex items-center gap-1">
            <ArrowLeft class="w-4 h-4" /> Back to Shop
          </Link>
          <span>/</span>
          <Link :href="`/shop?category=${encodeURIComponent(product.category?.name)}`" class="hover:text-brand-indigo">
            {{ product.category?.name }}
          </Link>
          <span>/</span>
          <span class="text-brand-navy font-semibold truncate">{{ product.name }}</span>
        </div>
        
        <!-- Cart Trigger -->
        <button 
          @click="store.isCartOpen = true"
          class="relative flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 text-brand-navy hover:text-brand-indigo font-bold transition-all"
        >
          <ShoppingCart class="w-4 h-4" />
          <span class="text-sm">View Cart</span>
          <span v-if="store.cartItemCount > 0" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-[10px] text-white font-bold border-2 border-white">
            {{ store.cartItemCount }}
          </span>
        </button>
      </div>
    </div>

    <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2">
          
          <!-- Product Images Gallery -->
          <div class="p-8 lg:p-12 border-b lg:border-b-0 lg:border-r border-slate-200 bg-slate-50/50">
            <!-- Main Image -->
            <div class="aspect-square bg-white rounded-2xl border border-slate-200 overflow-hidden flex items-center justify-center relative mb-6">
              <img v-if="mainImage" :src="mainImage" class="w-full h-full object-contain p-4" alt="Product Image" />
              <div v-else class="text-slate-300 flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mb-2 shadow-inner">
                  <span class="text-xs font-bold uppercase tracking-widest text-slate-400">NO IMG</span>
                </div>
              </div>
            </div>
            
            <!-- Thumbnails -->
            <div v-if="images.length > 1" class="flex gap-3 overflow-x-auto pb-2">
              <button 
                v-for="(img, index) in images" 
                :key="img.id"
                @click="activeImageIndex = index"
                class="w-16 h-16 shrink-0 rounded-lg border-2 overflow-hidden bg-white transition-all"
                :class="activeImageIndex === index ? 'border-brand-indigo ring-2 ring-brand-indigo/20' : 'border-slate-200 hover:border-brand-indigo/50'"
              >
                <img :src="img.image_path" class="w-full h-full object-cover" />
              </button>
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-8 lg:p-12 flex flex-col">
            <div class="mb-6">
              <div class="flex items-center gap-2 mb-3">
                <span class="text-xs font-bold text-brand-indigo uppercase bg-indigo-50 px-2.5 py-1 rounded-md">{{ product.category?.name }}</span>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">SKU: {{ product.slug.split('-').pop().toUpperCase() }}</span>
              </div>
              
              <h1 class="text-2xl font-extrabold text-brand-navy leading-tight">{{ product.name }}</h1>
              
              <div class="flex items-center gap-4 mt-4">
                <span class="text-2xl font-extrabold text-emerald-600">
                  {{ store.formatPrice(product.price) }}
                </span>
                <div 
                  class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold"
                  :class="product.stock ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-blue-50 text-blue-600 border border-blue-100'"
                >
                  <CheckCircle v-if="product.stock" class="w-4 h-4" />
                  <Truck v-else class="w-4 h-4" />
                  {{ product.stock ? 'In Stock' : 'Available for Sourcing' }}
                </div>
              </div>
            </div>

            <!-- Short Description -->
            <div class="text-slate-600 text-sm leading-relaxed mb-8 border-b border-slate-100 pb-8 whitespace-pre-line line-clamp-4">
              {{ product.description }}
            </div>

            <!-- Add to Cart Actions -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 mb-8">
              <label class="block text-sm font-semibold text-slate-700 mb-3">Quantity</label>
              <div class="flex items-center gap-4">
                <div class="flex items-center bg-white border border-slate-200 rounded-xl overflow-hidden h-12 shadow-sm">
                  <button @click="decreaseQty" class="w-12 h-full flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-brand-indigo transition-colors" :disabled="quantity <= 1">
                    <Minus class="w-4 h-4" />
                  </button>
                  <div class="w-12 h-full flex items-center justify-center font-bold text-brand-navy border-x border-slate-200">{{ quantity }}</div>
                  <button @click="increaseQty" class="w-12 h-full flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-brand-indigo transition-colors">
                    <Plus class="w-4 h-4" />
                  </button>
                </div>
                
                <button 
                  @click="handleAddToCart"
                  class="flex-1 flex items-center justify-center gap-2 text-white h-12 rounded-xl font-bold shadow-lg transition-all"
                  :class="product.allow_checkout ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/30' : 'bg-brand-indigo hover:bg-brand-hover shadow-brand-indigo/30'"
                >
                  <ShoppingCart class="w-5 h-5" />
                  {{ product.allow_checkout ? 'Add to Cart' : 'Add to Cart' }}
                </button>
              </div>
            </div>

            <!-- Value Props -->
            <div class="grid grid-cols-2 gap-4 mt-auto">
              <div class="flex items-start gap-3 p-4 rounded-xl bg-indigo-50/50 border border-indigo-100/50">
                <ShieldCheck class="w-6 h-6 text-brand-indigo shrink-0 mt-0.5" />
                <div>
                  <h4 class="text-sm font-bold text-brand-navy mb-1">OEM Warranty</h4>
                  <p class="text-xs text-slate-500">Fully backed by manufacturer guarantee.</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                <Truck class="w-6 h-6 text-emerald-600 shrink-0 mt-0.5" />
                <div>
                  <h4 class="text-sm font-bold text-brand-navy mb-1">Fast Logistics</h4>
                  <p class="text-xs text-slate-500">Secure enterprise delivery options.</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Detailed Information Section -->
      <div class="mt-12 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-200">
          
          <!-- Column 1: Description -->
          <div class="p-8 lg:p-10">
            <h3 class="text-lg font-bold text-brand-navy mb-6">Product Description</h3>
            <div class="prose max-w-none text-slate-600 whitespace-pre-line text-sm max-h-80 overflow-y-auto pr-4" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
              {{ product.description }}
              
              <p class="mt-8 pt-4 border-t border-slate-100 text-xs text-slate-500 italic">This product is sourced directly from OEM channels ensuring 100% authenticity and full compliance with enterprise infrastructure standards.</p>
            </div>
          </div>

          <!-- Column 2: Specifications -->
          <div class="p-8 lg:p-10 bg-slate-50/30">
            <h3 class="text-lg font-bold text-brand-navy mb-6">Specifications</h3>
            <div class="prose max-w-none text-slate-600 text-sm max-h-80 overflow-y-auto pr-4" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
              <div v-if="product.specifications" class="whitespace-pre-line mb-6 pb-6 border-b border-slate-200">
                {{ product.specifications }}
              </div>
              
              <table class="w-full text-left border-collapse border border-slate-200 bg-white">
                <tbody>
                  <tr class="border-b border-slate-200">
                    <th class="py-3 px-4 bg-slate-50 font-bold text-brand-navy w-1/3">Category</th>
                    <td class="py-3 px-4">{{ product.category?.name }}</td>
                  </tr>
                  <tr class="border-b border-slate-200">
                    <th class="py-3 px-4 bg-slate-50 font-bold text-brand-navy">SKU / Model</th>
                    <td class="py-3 px-4 uppercase">{{ product.slug.split('-').pop() }}</td>
                  </tr>
                  <tr>
                    <th class="py-3 px-4 bg-slate-50 font-bold text-brand-navy">Availability</th>
                    <td class="py-3 px-4">{{ product.stock ? 'In Stock' : 'Available for Sourcing' }}</td>
                  </tr>
                </tbody>
              </table>
              
              <div v-if="product.spec_sheet_path" class="mt-6 pt-6 border-t border-slate-200">
                <a :href="product.spec_sheet_path" download class="flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 text-brand-navy font-bold py-3 px-4 rounded-xl transition-colors border border-slate-200 shadow-sm group">
                  <svg class="w-5 h-5 text-brand-indigo group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Download PDF Datasheet
                </a>
              </div>
            </div>
          </div>

          <!-- Column 3: Shipping & SLA -->
          <div class="p-8 lg:p-10">
            <h3 class="text-lg font-bold text-brand-navy mb-6">Shipping & SLA</h3>
            <div class="prose max-w-none text-slate-600 text-sm space-y-4">
              <div>
                <strong class="text-brand-navy block mb-1">Standard Delivery:</strong>
                <p>3-5 Business days within Nairobi. Up to 7 days for regional branches.</p>
              </div>
              <div>
                <strong class="text-brand-navy block mb-1">SLA Agreements:</strong>
                <p>If this hardware is purchased under an active SLA, priority installation and 24/7 support rules apply immediately upon delivery.</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Related Products Section -->
      <div v-if="relatedProducts.length > 0" class="mt-16">
        <h2 class="text-2xl font-extrabold text-brand-navy mb-8 border-b border-slate-200 pb-4">Related Products</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div 
            v-for="rel in relatedProducts" 
            :key="rel.id"
            class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg hover:border-brand-indigo/30 transition-all flex flex-col group"
          >
            <Link :href="`/shop/product/${rel.slug}`" class="h-40 bg-slate-100 relative overflow-hidden flex items-center justify-center p-4 block">
              <img v-if="rel.images && rel.images.length > 0" 
                   :src="rel.images.find(i => i.is_primary)?.image_path || rel.images[0].image_path" 
                   class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                   alt="product image" />
              <template v-else>
                <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 z-0 group-hover:scale-105 transition-transform duration-500"></div>
                <div class="relative z-10 w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-300">
                  <span class="text-[10px] font-bold uppercase tracking-widest">{{ rel.category?.name?.substring(0,2) || 'DT' }}</span>
                </div>
              </template>
            </Link>
            
            <div class="p-4 flex flex-col flex-grow">
              <div class="text-[10px] font-bold text-brand-indigo mb-1 uppercase tracking-wide">{{ rel.category?.name }}</div>
              <Link :href="`/shop/product/${rel.slug}`" class="block">
                <h3 class="text-sm font-bold text-brand-navy leading-tight mb-2 hover:text-brand-indigo transition-colors line-clamp-2">{{ rel.name }}</h3>
              </Link>
              
              <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-auto">
                <div class="text-lg font-extrabold text-brand-navy">
                  {{ store.formatPrice(rel.price) }}
                </div>
                <button 
                  @click.prevent="store.addToCart(rel);"
                  class="bg-brand-navy hover:bg-brand-indigo text-white p-2 rounded-lg transition-colors shadow-md hover:shadow-brand-indigo/30"
                  title="Add to Quote"
                >
                  <ShoppingCart class="w-3.5 h-3.5" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>



  </PublicLayout>
</template>
