<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useProductStore } from '@/Stores/useProductStore';
import { ArrowLeft, Send, CheckCircle2, ShoppingCart } from 'lucide-vue-next';

const store = useProductStore();

const form = useForm({
  name: '',
  email: '',
  phone: '',
  company: '',
  address: '',
  notes: '',
  cart: []
});

onMounted(() => {
  form.cart = store.cart;
});

const submitCheckout = () => {
  if (store.cart.length === 0) {
    alert("Your cart is empty.");
    return;
  }
  
  form.cart = store.cart;
  form.post(route('checkout.store'), {
    preserveScroll: true,
    onSuccess: () => {
      store.cart = []; // Empty the cart
    }
  });
};
</script>

<template>
  <Head title="Checkout Quote Request - Dignity Traders Ltd" />

  <PublicLayout>
    <div class="bg-slate-50 min-h-screen py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-extrabold text-brand-navy tracking-tight">{{ store.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000) ? 'Request Quote' : 'Secure Checkout' }}</h1>
            <p class="text-slate-500 mt-1 text-sm">{{ store.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000) ? 'Review your selected items and submit for a formal proposal.' : 'Complete your purchase securely online.' }}</p>
          </div>
          <Link :href="route('shop')" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-indigo hover:text-brand-hover transition bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <ArrowLeft class="w-4 h-4" />
            Back to Shop
          </Link>
        </div>

        <div v-if="store.cart.length === 0" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
          <ShoppingCart class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h2 class="text-xl font-bold text-brand-navy mb-2">Your Cart is Empty</h2>
          <p class="text-slate-500 mb-6">Browse our products and add items to your cart to request a quote.</p>
          <Link :href="route('shop')" class="inline-flex items-center gap-2 bg-brand-indigo text-white font-bold px-6 py-3 rounded-xl shadow-md hover:bg-brand-hover transition">
            Browse Products
          </Link>
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-8">
          
          <!-- Left Column: Customer Details Form -->
          <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
              <h2 class="text-xl font-bold text-brand-navy mb-6 pb-4 border-b border-slate-100 flex items-center gap-2">
                <CheckCircle2 class="w-5 h-5 text-emerald-500" />
                Contact Information
              </h2>
              
              <form @submit.prevent="submitCheckout" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Full Name *</label>
                    <input 
                      v-model="form.name"
                      type="text" 
                      required 
                      class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                      placeholder="John Doe"
                    />
                    <div v-if="form.errors.name" class="text-red-500 text-[10px] mt-1">{{ form.errors.name }}</div>
                  </div>
                  <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wide mb-1">Company Name</label>
                    <input 
                      v-model="form.company"
                      type="text" 
                      class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                      placeholder="Tech Solutions Ltd"
                    />
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address *</label>
                    <input 
                      v-model="form.email"
                      type="email" 
                      required 
                      class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                      placeholder="john@example.com"
                    />
                    <div v-if="form.errors.email" class="text-red-500 text-[10px] mt-1">{{ form.errors.email }}</div>
                  </div>
                  <div>
                    <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wide mb-1">Phone Number *</label>
                    <input 
                      v-model="form.phone"
                      type="tel" 
                      required 
                      class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                      placeholder="+254 700 000 000"
                    />
                    <div v-if="form.errors.phone" class="text-red-500 text-[10px] mt-1">{{ form.errors.phone }}</div>
                  </div>
                </div>

                <div>
                  <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wide mb-1">Shipping/Delivery Address *</label>
                  <textarea 
                    v-model="form.address"
                    required
                    rows="2" 
                    class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                    placeholder="Enter full shipping address, city, and zip code"
                  ></textarea>
                  <div v-if="form.errors.address" class="text-red-500 text-[10px] mt-1">{{ form.errors.address }}</div>
                </div>

                <div>
                  <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wide mb-1">Additional Notes (Optional)</label>
                  <textarea 
                    v-model="form.notes"
                    rows="3" 
                    class="w-full text-xs rounded-lg border border-slate-200 px-3 py-2 focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo transition bg-slate-50 focus:bg-white"
                    placeholder="Any specific configurations, delivery requirements, or questions..."
                  ></textarea>
                </div>

                <div class="pt-4">
                  <button 
                    v-if="store.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000)"
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full bg-brand-indigo hover:bg-brand-hover text-white py-3 rounded-lg font-bold text-sm shadow-md shadow-brand-indigo/30 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
                  >
                    <span v-if="form.processing">Submitting Request...</span>
                    <span v-else>Submit Quote Request</span>
                  </button>
                  <button 
                    v-else
                    type="button" 
                    disabled
                    class="w-full bg-slate-200 text-slate-500 py-3 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2 opacity-70 cursor-not-allowed"
                  >
                    Online Payment Coming Soon
                  </button>
                  <p v-if="store.cartTotalUSD > ($page.props.globalSettings?.checkout_limit_usd || 5000)" class="text-center text-[10px] text-slate-400 mt-3">By submitting this request, you are not committing to a purchase.</p>
                  <p v-else class="text-center text-[10px] text-red-500 mt-3 font-medium">Online payment integration is currently under development. Please increase your cart total above ${{ $page.props.globalSettings?.checkout_limit_usd || 5000 }} to request a quote instead.</p>
                </div>
              </form>
            </div>
          </div>

          <!-- Right Column: Order Summary -->
          <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-24">
              <div class="p-4 bg-slate-50 border-b border-slate-200">
                <h2 class="text-sm font-bold text-brand-navy">Order Summary</h2>
                <p class="text-[10px] text-slate-500 mt-0.5">{{ store.cartItemCount }} Items in your request</p>
              </div>
              
              <div class="p-4 max-h-[400px] overflow-y-auto divide-y divide-slate-100">
                <div v-for="item in store.cart" :key="item.id" class="py-3 first:pt-0 last:pb-0 flex gap-3">
                  <div class="w-12 h-12 rounded-lg bg-slate-100 shrink-0 flex items-center justify-center overflow-hidden border border-slate-200">
                    <img v-if="item.images && item.images.length > 0" :src="item.images.find(i => i.is_primary)?.image_path || item.images[0].image_path" class="w-full h-full object-cover" />
                    <ShoppingCart v-else class="w-5 h-5 text-slate-300" />
                  </div>
                  <div class="flex-grow">
                    <h4 class="text-xs font-semibold text-brand-navy leading-tight mb-1">{{ item.name }}</h4>
                    <div class="flex justify-between items-center text-[11px]">
                      <span class="text-slate-500">Qty: {{ item.quantity }}</span>
                      <span class="font-bold text-brand-navy">{{ store.formatPrice(item.price * item.quantity) }}</span>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="p-4 bg-slate-50 border-t border-slate-200">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                  <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">Currency</span>
                  <div class="flex items-center bg-white rounded-lg p-0.5 border border-slate-200 shadow-sm">
                    <button 
                      type="button"
                      @click="store.selectedCurrency = 'USD'"
                      class="px-3 py-1 text-[11px] font-bold rounded-md transition-all"
                      :class="store.selectedCurrency === 'USD' ? 'bg-brand-indigo text-white shadow' : 'text-slate-500 hover:text-brand-navy hover:bg-slate-50'"
                    >USD</button>
                    <button 
                      type="button"
                      @click="store.selectedCurrency = 'KES'"
                      class="px-3 py-1 text-[11px] font-bold rounded-md transition-all"
                      :class="store.selectedCurrency === 'KES' ? 'bg-brand-indigo text-white shadow' : 'text-slate-500 hover:text-brand-navy hover:bg-slate-50'"
                    >KSH</button>
                  </div>
                </div>

                <div class="flex justify-between items-center mb-2 text-xs">
                  <span class="text-slate-600 font-medium">Subtotal</span>
                  <span class="font-bold text-slate-800">{{ store.formattedCartTotal }}</span>
                </div>
                <div class="flex justify-between items-center mb-4 text-[11px] text-slate-500">
                  <span>Shipping & Taxes</span>
                  <span>Calculated at checkout</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                  <span class="text-sm font-bold text-brand-navy">Estimated Total</span>
                  <span class="text-xl font-extrabold text-brand-indigo">{{ store.formattedCartTotal }}</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </PublicLayout>
</template>
