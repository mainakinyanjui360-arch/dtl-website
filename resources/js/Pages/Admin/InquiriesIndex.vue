<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Trash2, MessageCircle, Send, CheckCircle, Clock } from 'lucide-vue-next';

defineProps({
  inquiries: {
    type: Array,
    required: true
  }
});

const deleteForm = useForm({});
const sendForm = useForm({
  reply_message: '',
  attachment: null
});
const selectedInquiry = ref(null);

const deleteInquiry = (id) => {
  if (confirm('Are you sure you want to delete this inquiry?')) {
    deleteForm.delete(route('admin.inquiries.destroy', id), {
      preserveScroll: true
    });
  }
};

const handleFileUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    sendForm.attachment = file;
  }
};

const sendReply = () => {
  if (!sendForm.reply_message) {
    alert('Please write a reply message.');
    return;
  }
  
  sendForm.post(route('admin.inquiries.reply', selectedInquiry.value.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      selectedInquiry.value = null;
      sendForm.reset();
    }
  });
};
</script>

<template>
  <Head title="Inquiries - Admin" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy flex items-center gap-2">
          <MessageCircle class="w-6 h-6 text-slate-400" />
          Contact Inquiries
        </h1>
      </header>

      <main class="p-8 flex-1 overflow-y-auto">
        <div v-if="inquiries.length === 0" class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
          <MessageCircle class="w-16 h-16 text-slate-300 mx-auto mb-4" />
          <h3 class="text-lg font-bold text-brand-navy mb-2">No Inquiries Yet</h3>
          <p class="text-slate-500 max-w-md mx-auto">New contact form messages will appear here.</p>
        </div>

        <div v-else class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
          <!-- Table Toolbar -->
          <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <div class="relative w-full sm:w-72">
              <span class="absolute left-3 top-2.5 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              </span>
              <input type="text" placeholder="Search inquiries..." class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo bg-white">
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
                  <th class="px-6 py-4 font-semibold min-w-[200px]">Sender</th>
                  <th class="px-6 py-4 font-semibold min-w-[300px]">Subject</th>
                  <th class="px-6 py-4 font-semibold text-right sticky right-0 z-10 bg-slate-50">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr v-for="inquiry in inquiries" :key="inquiry.id" class="hover:bg-slate-50/80 transition-colors cursor-pointer group" @click="selectedInquiry = inquiry">
                  <td class="px-6 py-4 text-center sticky left-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors" @click.stop>
                    <input type="checkbox" class="rounded border-slate-300 text-brand-indigo focus:ring-brand-indigo cursor-pointer">
                  </td>
                  <td class="px-6 py-4 text-center">
                    <div v-if="inquiry.status === 'replied'" class="inline-flex items-center justify-center gap-1.5 text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-xs font-semibold border border-emerald-100">
                      <CheckCircle class="w-3.5 h-3.5" />
                      <span>Replied</span>
                    </div>
                    <div v-else class="inline-flex items-center justify-center gap-1.5 text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md text-xs font-semibold border border-amber-100">
                      <Clock class="w-3.5 h-3.5" />
                      <span>New</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-slate-500 font-medium whitespace-nowrap">{{ new Date(inquiry.created_at).toLocaleDateString() }}</td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-brand-navy">{{ inquiry.name }}</div>
                    <div class="text-xs text-slate-500">{{ inquiry.email }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-slate-700 truncate max-w-[350px]">{{ inquiry.subject }}</div>
                  </td>
                  <td class="px-6 py-4 text-right space-x-2 sticky right-0 z-10 bg-white group-hover:bg-slate-50/80 transition-colors">
                    <button @click.stop="selectedInquiry = inquiry" class="p-2 text-slate-400 hover:text-brand-indigo hover:bg-indigo-50 rounded-lg transition shadow-sm border border-slate-200 group-hover:border-indigo-200 bg-white" title="View & Reply">
                      <MessageCircle class="w-4 h-4" />
                    </button>
                    <button @click.stop="deleteInquiry(inquiry.id)" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shadow-sm border border-slate-200 group-hover:border-red-200 bg-white" title="Delete">
                      <Trash2 class="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination Footer -->
          <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex items-center justify-between text-sm text-slate-500">
            <div>Showing <span class="font-bold text-slate-700">{{ inquiries.length }}</span> items</div>
            <div class="flex gap-1">
              <button class="px-3 py-1 rounded border border-slate-200 bg-white text-slate-400 cursor-not-allowed">Prev</button>
              <button class="px-3 py-1 rounded border border-slate-200 bg-white hover:bg-slate-50 text-brand-navy font-medium">Next</button>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- View & Reply Modal -->
    <div v-if="selectedInquiry" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-brand-navy/60 backdrop-blur-sm" @click="selectedInquiry = null"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl p-0 relative z-10 max-h-[90vh] overflow-y-auto flex flex-col md:flex-row">
        
        <!-- Left Side: Request Details -->
        <div class="p-6 md:w-1/2 border-b md:border-b-0 md:border-r border-slate-100 bg-slate-50">
          <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-200 pb-2">
            Inquiry Details
          </h3>
          <div class="space-y-4 text-sm">
            <div>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Sender</span>
              <span class="block font-bold text-slate-700">{{ selectedInquiry.name }}</span>
              <a :href="'mailto:' + selectedInquiry.email" class="text-brand-indigo hover:underline">{{ selectedInquiry.email }}</a>
            </div>
            <div>
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</span>
              <span class="block font-bold text-slate-800">{{ selectedInquiry.subject }}</span>
            </div>
            <div class="pt-4 border-t border-slate-200">
              <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Message</span>
              <div class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ selectedInquiry.message }}</div>
            </div>
          </div>
        </div>

        <!-- Right Side: Action (Send Reply) -->
        <div class="p-6 md:w-1/2 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-bold text-brand-navy mb-4 border-b border-slate-100 pb-2">
              Reply
            </h3>
            
            <div v-if="selectedInquiry.status === 'replied'" class="bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 mb-6 flex items-start gap-3">
              <CheckCircle class="w-5 h-5 shrink-0 mt-0.5" />
              <div class="text-sm">
                <strong class="block">Already Replied</strong>
                You have previously replied to this inquiry.
              </div>
            </div>

            <form @submit.prevent="sendReply" class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Your Message</label>
                <textarea 
                  v-model="sendForm.reply_message" 
                  rows="5" 
                  required
                  placeholder="Type your response here..."
                  class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                ></textarea>
              </div>

              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Optional Attachment</label>
                <input 
                  type="file" 
                  @change="handleFileUpload"
                  class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-brand-indigo
                    hover:file:bg-indigo-100
                  "/>
              </div>

              <div class="pt-6 mt-6 border-t border-slate-100 flex gap-3 justify-end">
                <button type="button" @click="selectedInquiry = null" class="px-4 py-2 rounded-lg font-bold text-sm text-slate-600 hover:bg-slate-100 transition">Cancel</button>
                <button type="submit" :disabled="sendForm.processing" class="bg-brand-indigo hover:bg-brand-hover text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition disabled:opacity-50">
                  <span v-if="sendForm.processing">Sending...</span>
                  <template v-else>
                    <Send class="w-4 h-4" /> Send Reply
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
