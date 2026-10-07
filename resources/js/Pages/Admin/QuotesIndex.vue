<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Trash2, MessageSquare, FileText, Send, CheckCircle, Clock } from 'lucide-vue-next';

defineProps({
  quotes: {
    type: Array,
    required: true
  }
});

const deleteForm = useForm({});
const sendForm = useForm({
  pdf: null
});
const selectedQuote = ref(null);

const deleteQuote = (id) => {
  if (confirm('Are you sure you want to delete this quote request?')) {
    deleteForm.delete(route('admin.quotes.destroy', id), {
      preserveScroll: true
    });
  }
};

const handlePdfUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    sendForm.pdf = file;
  }
};

const sendQuote = () => {
  if (!sendForm.pdf) {
    alert('Please attach a PDF proposal first.');
    return;
  }
  
  sendForm.post(route('admin.quotes.send', selectedQuote.value.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      selectedQuote.value = null;
      sendForm.reset();
    }
  });
};
</script>

<template>
  <Head title="Quote Requests - Admin" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy flex items-center gap-2">
          <MessageSquare class="w-6 h-6 text-slate-400" />
          Quote Requests
        </h1>
      </header>

      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="quotes.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <MessageSquare class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Requests Yet</h3>
          <p class="text-slate-500 max-w-md mx-auto">New quotation requests will appear here.</p>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
          <!-- Table Toolbar -->
          <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <div class="relative w-full sm:w-72">
              <span class="absolute left-3 top-2.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              </span>
              <input type="text" placeholder="Search quotes..." class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo bg-white">
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
                  <th class="px-6 py-4 font-semibold text-center w-24">Status</th>
                  <th class="px-6 py-4 font-semibold">Date</th>
                  <th class="px-6 py-4 font-semibold min-w-[200px]">Sender Details</th>
                  <th class="px-6 py-4 font-semibold min-w-[200px]">Service</th>
                  <th class="px-6 py-4 font-semibold text-right sticky right-0 z-10 bg-slate-50">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr v-for="quote in quotes" :key="quote.id" class="hover:bg-slate-50/80 transition-colors cursor-pointer group" @click="selectedQuote = quote">
                  <td class="px-6 py-4 text-center sticky left-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors" @click.stop>
                    <input type="checkbox" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo cursor-pointer">
                  </td>
                  <td class="px-6 py-4 text-center">
                    <div v-if="quote.status === 'sent'" class="inline-flex items-center justify-center gap-1.5 text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs font-semibold border border-emerald-100">
                      <CheckCircle class="w-3.5 h-3.5" />
                      <span>Sent</span>
                    </div>
                    <div v-else class="inline-flex items-center justify-center gap-1.5 text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md text-xs font-semibold border border-amber-100">
                      <Clock class="w-3.5 h-3.5" />
                      <span>New</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-slate-500 font-medium whitespace-nowrap">{{ new Date(quote.created_at).toLocaleDateString() }}</td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-brand-navy">{{ quote.name }}</div>
                    <div class="text-xs text-slate-500">{{ quote.email }} • {{ quote.phone }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-indigo-50 text-brand-indigo font-medium text-xs border border-indigo-100">
                      <FileText class="w-3.5 h-3.5" />
                      {{ quote.service || 'General' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right space-x-2 sticky right-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors">
                    <button @click.stop="selectedQuote = quote" class="p-2 text-slate-400 hover:text-brand-indigo hover:bg-indigo-50 rounded-lg transition shadow-sm border border-slate-200 group-hover:border-indigo-200 bg-white" title="View & Reply">
                      <MessageSquare class="w-4 h-4" />
                    </button>
                    <button @click.stop="deleteQuote(quote.id)" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shadow-sm border border-slate-200 group-hover:border-red-200 bg-white" title="Delete">
                      <Trash2 class="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination Footer -->
          <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between text-sm text-slate-500">
            <div>Showing <span class="font-bold text-slate-700">{{ quotes.length }}</span> items</div>
            <div class="flex gap-1">
              <button class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">Prev</button>
              <button class="px-3 py-1 rounded border border-slate-200 bg-white hover:bg-slate-50 text-brand-navy font-medium">Next</button>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- View & Send Modal -->
    <div v-if="selectedQuote" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-brand-navy/60 backdrop-blur-sm" @click="selectedQuote = null"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-0 relative z-10 max-h-[90vh] overflow-y-auto flex flex-col md:flex-row">
        
        <!-- Left Side: Request Details -->
        <div class="p-6 md:w-1/2 border-b md:border-b-0 md:border-r border-slate-100 bg-slate-50">
          <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-200 pb-2">
            Request Details
          </h3>
          <div class="space-y-4 text-sm">
            <div>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Sender</span>
              <span class="block font-bold text-slate-700">{{ selectedQuote.name }}</span>
              <a :href="'mailto:' + selectedQuote.email" class="text-brand-indigo hover:underline">{{ selectedQuote.email }}</a>
              <span class="block text-slate-600">{{ selectedQuote.phone || 'No phone' }}</span>
            </div>
            <div>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Company</span>
              <span class="block text-slate-700">{{ selectedQuote.company || 'N/A' }}</span>
            </div>
            <div>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Service</span>
              <span class="block text-slate-700">{{ selectedQuote.service || 'N/A' }}</span>
            </div>
            <div class="pt-4 border-t border-slate-200">
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Message</span>
              <div class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ selectedQuote.message || 'No additional message.' }}</div>
            </div>
          </div>
        </div>

        <!-- Right Side: Action (Send Quote) -->
        <div class="p-6 md:w-1/2 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">
              Send Proposal
            </h3>
            
            <div v-if="selectedQuote.status === 'sent'" class="bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 mb-6 flex items-start gap-3">
              <CheckCircle class="w-5 h-5 shrink-0 mt-0.5" />
              <div class="text-sm">
                <strong class="block">Quotation Sent</strong>
                A proposal has already been sent to this customer. You can send another one if needed.
              </div>
            </div>

            <form @submit.prevent="sendQuote" class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Attach PDF Quotation</label>
                <input 
                  type="file" 
                  accept=".pdf"
                  required
                  @change="handlePdfUpload"
                  class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-brand-indigo
                    hover:file:bg-indigo-100
                  "/>
              </div>

              <div class="bg-slate-50 border border-slate-100 p-4 rounded-lg mt-4">
                <span class="block text-xs font-bold text-slate-500 uppercase mb-2">Email Preview</span>
                <p class="text-xs text-slate-600 leading-relaxed font-mono">
                  Dear {{ selectedQuote.name }},<br><br>
                  Your requested quotation has been prepared and is attached to this email.<br><br>
                  Best Regards,<br>Dignity Traders Ltd
                </p>
              </div>

              <div class="pt-6 mt-6 border-t border-slate-100 flex gap-3 justify-end">
                <button type="button" @click="selectedQuote = null" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100 transition">Cancel</button>
                <button type="submit" :disabled="sendForm.processing" class="bg-brand-indigo hover:bg-brand-hover text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition disabled:opacity-50">
                  <span v-if="sendForm.processing">Sending...</span>
                  <template v-else>
                    <Send class="w-4 h-4" /> Send Email
                  </template>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
