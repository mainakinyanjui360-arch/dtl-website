<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useProductStore } from '@/Stores/useProductStore';
import { ShoppingCart, Search, Filter, Plus, Minus, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  initialCategory: {
    type: String,
    default: 'All'
  },
  dbCategories: {
    type: Array,
    default: () => []
  },
  dbProducts: {
    type: Array,
    default: () => []
  }
});

const store = useProductStore();
const activeCategory = ref(props.initialCategory || 'All');
const searchQuery = ref('');
const isCartOpen = ref(false);

const allCategories = computed(() => {
  return ['All', ...props.dbCategories.map(c => c.name)];
});

// Filter state
const minPrice = ref(0);
const maxPrice = ref(10000);
const filteredProducts = ref([]);

// Pagination state
const currentPage = ref(1);
const itemsPerPage = 6;

const filterProducts = () => {
  let list = props.dbProducts;

  if (activeCategory.value !== 'All') {
    list = list.filter(p => p.category?.name === activeCategory.value);
  }
  
  // Search filter
  if (searchQuery.value) {
    list = list.filter(p => 
      p.name.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
      (p.description && p.description.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
  }
  
  // Price filter
  list = list.filter(p => parseFloat(p.price) >= minPrice.value && parseFloat(p.price) <= maxPrice.value);
  
  filteredProducts.value = list;
  currentPage.value = 1; // Reset to first page on filter change
};

// Re-filter when category, search, or price changes
watch([activeCategory, searchQuery, minPrice, maxPrice], () => {
  filterProducts();
});

// Update URL without full page reload when category changes
watch(activeCategory, (newCat) => {
  const url = new URL(window.location);
  if (newCat === 'All') {
    url.searchParams.delete('category');
  } else {
    url.searchParams.set('category', newCat);
  }
  window.history.pushState({}, '', url);
});

const totalPages = computed(() => Math.ceil(filteredProducts.value.length / itemsPerPage));

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredProducts.value.slice(start, end);
});

onMounted(() => {
  filterProducts();
});
</script>

<template>
  <Head title="Enterprise Shop - Dignity Traders Ltd" />

  <PublicLayout>
    <!-- Page Header -->
    <section class="bg-brand-navy py-12 border-b border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
          <h1 class="text-3xl font-extrabold text-white tracking-tight">Enterprise Hardware Shop</h1>
          <p class="text-slate-400 text-sm mt-2">Verified OEM products backed by local warranty.</p>
        </div>
        
        <!-- Cart Trigger -->
        <button 
          @click="isCartOpen = true"
          class="relative flex items-center gap-2 bg-brand-indigo hover:bg-brand-hover text-white px-5 py-2.5 rounded-lg font-semibold transition-colors shadow-lg"
        >
          <ShoppingCart class="w-5 h-5" />
          <span>Cart ({{ store.cartItemCount }})</span>
          <span v-if="store.cartItemCount > 0" class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center text-xs font-bold border-2 border-brand-navy">
            {{ store.cartItemCount }}
          </span>
        </button>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-slate-50 min-h-screen relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8">
        
        <!-- Left Sidebar: Filters -->
        <div class="w-full lg:w-64 shrink-0 space-y-6">
          <!-- Search -->
          <div class="relative">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search products..." 
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo bg-white"
            >
          </div>

          <!-- Categories -->
          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <h3 class="font-bold text-brand-navy mb-4 flex items-center gap-2">
              <Filter class="w-4 h-4 text-brand-indigo" />
              Categories
            </h3>
            <ul class="space-y-2">
              <li v-for="cat in allCategories" :key="cat">
                <button 
                  @click="activeCategory = cat"
                  class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors"
                  :class="activeCategory === cat ? 'bg-indigo-50 text-brand-indigo font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-brand-navy'"
                >
                  {{ cat }}
                </button>
              </li>
            </ul>
          </div>

          <!-- Price Range -->
          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <h3 class="font-bold text-brand-navy mb-4 text-sm uppercase tracking-wider">Price Range</h3>
            <div class="space-y-4">
              <div class="flex items-center gap-4">
                <div class="flex-1">
                  <label class="text-xs text-slate-500 mb-1 block">Min ($)</label>
                  <input type="number" v-model="minPrice" min="0" class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
                </div>
                <div class="flex-1">
                  <label class="text-xs text-slate-500 mb-1 block">Max ($)</label>
                  <input type="number" v-model="maxPrice" min="0" class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo">
                </div>
              </div>
              <input type="range" v-model="maxPrice" min="0" max="10000" step="100" class="w-full h-1 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-brand-indigo">
            </div>
          </div>
        </div>

        <!-- Right Content: Products Grid -->
        <div class="flex-grow flex flex-col">
          <!-- Results Count Header -->
          <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-brand-navy">
              {{ activeCategory === 'All' ? 'All Products' : activeCategory }}
            </h2>
            <span class="text-sm font-medium text-slate-500 bg-white px-3 py-1 rounded-full shadow-sm border border-slate-100">
              Showing {{ filteredProducts.length }} product<span v-if="filteredProducts.length !== 1">s</span>
            </span>
          </div>

          <div v-if="filteredProducts.length === 0" class="text-center py-20 bg-white rounded-2xl border border-slate-200 flex-grow">
            <p class="text-slate-500 font-medium">No products found matching your criteria.</p>
          </div>
          
          <div v-else class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            <div 
              v-for="product in paginatedProducts" 
              :key="product.id"
              class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg hover:border-brand-indigo/30 transition-all flex flex-col group"
            >
              <!-- Product Image Block -->
              <Link :href="`/shop/product/${product.slug}`" class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center p-6 block">
                <!-- Real Image -->
                <img v-if="product.images && product.images.length > 0" 
                     :src="product.images.find(i => i.is_primary)?.image_path || product.images[0].image_path" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                     alt="product image" />
                
                <!-- Fallback gradient if no image exists -->
                <template v-else>
                  <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 z-0 group-hover:scale-105 transition-transform duration-500"></div>
                  <div class="relative z-10 w-24 h-24 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-300">
                    <span class="text-xs font-bold uppercase tracking-widest">{{ product.category?.name?.substring(0,2) || 'DT' }}</span>
                  </div>
                </template>
              </Link>
              
              <div class="p-5 flex flex-col flex-grow">
                <div class="text-xs font-bold text-brand-indigo mb-2 uppercase tracking-wide">{{ product.category?.name }}</div>
                <Link :href="`/shop/product/${product.slug}`" class="block">
                  <h3 class="text-lg font-bold text-brand-navy leading-tight mb-2 hover:text-brand-indigo transition-colors">{{ product.name }}</h3>
                </Link>
                <p class="text-sm text-slate-500 mb-4 flex-grow line-clamp-2">{{ product.description }}</p>
                
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                  <div class="text-xl font-extrabold text-brand-navy">${{ parseFloat(product.price).toFixed(2) }}</div>
                  <button 
                    @click="store.addToCart(product)"
                    class="bg-brand-navy hover:bg-brand-indigo text-white p-2.5 rounded-lg transition-colors shadow-md hover:shadow-brand-indigo/30"
                    title="Add to Cart"
                  >
                    <Plus class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="totalPages > 1" class="flex justify-center mt-auto pt-8">
            <div class="flex items-center gap-2 bg-white px-2 py-2 rounded-xl border border-slate-200 shadow-sm">
              <button 
                @click="currentPage > 1 && currentPage--"
                :disabled="currentPage === 1"
                class="w-10 h-10 flex items-center justify-center rounded-lg font-bold text-sm transition-colors"
                :class="currentPage === 1 ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy'"
              >
                &larr;
              </button>
              
              <button 
                v-for="page in totalPages" 
                :key="page"
                @click="currentPage = page"
                class="w-10 h-10 flex items-center justify-center rounded-lg font-bold text-sm transition-colors"
                :class="currentPage === page ? 'bg-brand-indigo text-white shadow-md shadow-brand-indigo/30' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy'"
              >
                {{ page }}
              </button>
              
              <button 
                @click="currentPage < totalPages && currentPage++"
                :disabled="currentPage === totalPages"
                class="w-10 h-10 flex items-center justify-center rounded-lg font-bold text-sm transition-colors"
                :class="currentPage === totalPages ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy'"
              >
                &rarr;
              </button>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Slide-over Cart Panel -->
    <div v-if="isCartOpen" class="fixed inset-0 z-50 overflow-hidden">
      <!-- Backdrop -->
      <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="isCartOpen = false"></div>
      
      <!-- Panel -->
      <div class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col transform transition-transform duration-300">
        <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50">
          <h2 class="text-xl font-bold text-brand-navy flex items-center gap-2">
            <ShoppingCart class="w-5 h-5 text-brand-indigo" />
            Your Request Cart
          </h2>
          <button @click="isCartOpen = false" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="flex-grow overflow-y-auto p-6">
          <div v-if="store.cart.length === 0" class="h-full flex flex-col items-center justify-center text-slate-400 space-y-4">
            <ShoppingCart class="w-16 h-16 opacity-20" />
            <p>Your cart is empty.</p>
            <button @click="isCartOpen = false" class="text-brand-indigo font-bold text-sm hover:underline">Continue Shopping</button>
          </div>

          <div v-else class="space-y-6">
            <div v-for="item in store.cart" :key="item.id" class="flex gap-4 p-4 rounded-xl border border-slate-100 bg-white shadow-sm">
              <div class="w-16 h-16 rounded-lg bg-slate-100 shrink-0 flex items-center justify-center text-xs font-bold text-slate-300 overflow-hidden">
                <img v-if="item.images && item.images.length > 0" :src="item.images.find(i => i.is_primary)?.image_path || item.images[0].image_path" class="w-full h-full object-cover" />
                <span v-else>Img</span>
              </div>
              <div class="flex-grow">
                <h4 class="text-sm font-bold text-brand-navy mb-1 leading-tight">{{ item.name }}</h4>
                <div class="text-xs text-slate-500 mb-2">${{ parseFloat(item.price).toFixed(2) }}</div>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden">
                    <button @click="store.updateQuantity(item.id, item.quantity - 1)" class="w-7 h-7 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition" :disabled="item.quantity <= 1">
                      <Minus class="w-3 h-3" />
                    </button>
                    <div class="w-8 text-center text-xs font-semibold">{{ item.quantity }}</div>
                    <button @click="store.updateQuantity(item.id, item.quantity + 1)" class="w-7 h-7 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                      <Plus class="w-3 h-3" />
                    </button>
                  </div>
                  <button @click="store.removeFromCart(item.id)" class="text-red-400 hover:text-red-600 p-1 transition">
                    <Trash2 class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="store.cart.length > 0" class="p-6 border-t border-slate-100 bg-slate-50">
          <div class="flex justify-between items-center mb-6">
            <span class="text-slate-600 font-medium">Estimated Total</span>
            <span class="text-2xl font-extrabold text-brand-navy">${{ store.cartTotal.toFixed(2) }}</span>
          </div>
          <button class="w-full bg-brand-indigo hover:bg-brand-hover text-white py-3.5 rounded-xl font-bold shadow-lg shadow-brand-indigo/30 transition-all flex items-center justify-center gap-2">
            Proceed to Quote Request
            <ArrowRight class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>

  </PublicLayout>
</template>
