<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { Package, Plus, LogOut, CheckCircle, XCircle } from 'lucide-vue-next';

defineProps({
  products: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <Head title="Admin Dashboard - Dignity Traders" />

  <div class="min-h-screen bg-slate-50 flex">
    
    <!-- Sidebar -->
    <div class="w-64 bg-brand-navy text-white flex flex-col shrink-0">
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
      <div class="mt-auto p-6 border-t border-slate-800">
        <Link href="/shop/logout" method="post" as="button" class="flex items-center gap-3 text-slate-400 hover:text-white transition w-full">
          <LogOut class="w-5 h-5" />
          Sign Out
        </Link>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy">Product Management</h1>
        <Link href="/shop/admin/products/create" class="bg-brand-indigo hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors">
          <Plus class="w-4 h-4" />
          Add Product
        </Link>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="products.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <Package class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Products Yet</h3>
          <p class="text-slate-500 mb-6 max-w-md mx-auto">Get started by adding your first enterprise hardware product to the catalog.</p>
          <Link href="/shop/admin/products/create" class="inline-block bg-brand-navy hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-bold text-sm transition-colors">Create First Product</Link>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                <th class="p-4 font-semibold">Image</th>
                <th class="p-4 font-semibold">Name</th>
                <th class="p-4 font-semibold">Category</th>
                <th class="p-4 font-semibold">Price</th>
                <th class="p-4 font-semibold">Stock</th>
                <th class="p-4 font-semibold">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="product in products" :key="product.id" class="hover:bg-slate-50 transition-colors">
                <td class="p-4">
                  <div v-if="product.images && product.images.length > 0" class="w-12 h-12 rounded bg-slate-100 overflow-hidden">
                    <img :src="product.images.find(img => img.is_primary)?.image_path || product.images[0].image_path" class="w-full h-full object-cover" />
                  </div>
                  <div v-else class="w-12 h-12 rounded bg-slate-100 flex items-center justify-center text-xs text-slate-400">No Img</div>
                </td>
                <td class="p-4 font-bold text-brand-navy">{{ product.name }}</td>
                <td class="p-4 text-sm text-slate-500">{{ product.category?.name }}</td>
                <td class="p-4 font-semibold text-brand-indigo">${{ parseFloat(product.price).toFixed(2) }}</td>
                <td class="p-4 text-sm font-semibold">
                  <span v-if="product.stock" class="text-emerald-600">In Stock</span>
                  <span v-else class="text-slate-400">Out of Stock</span>
                </td>
                <td class="p-4">
                  <span v-if="product.is_active" class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs font-bold">
                    <CheckCircle class="w-3 h-3" /> Active
                  </span>
                  <span v-else class="inline-flex items-center gap-1 text-slate-500 bg-slate-100 px-2 py-1 rounded-md text-xs font-bold">
                    <XCircle class="w-3 h-3" /> Inactive
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>

  </div>
</template>
