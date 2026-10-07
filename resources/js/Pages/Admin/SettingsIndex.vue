<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Settings as SettingsIcon, Save } from 'lucide-vue-next';

const props = defineProps({
  settings: {
    type: Array,
    required: true
  }
});

// Convert array of settings to form structure
const form = useForm({
  settings: props.settings.map(s => ({ key: s.key, value: s.value }))
});

const getSettingValue = (key) => {
  const item = form.settings.find(s => s.key === key);
  return item ? item.value : '';
};

const updateSettingValue = (key, value) => {
  const item = form.settings.find(s => s.key === key);
  if (item) {
    item.value = value;
  } else {
    form.settings.push({ key, value });
  }
};

const submit = () => {
  form.post('/shop/admin/settings', {
    preserveScroll: true
  });
};

const syncCurrency = () => {
  form.post('/shop/admin/settings/sync-currency', {
    preserveScroll: true
  });
};
</script>

<template>
  <Head title="Site Settings - Dignity Traders" />

  <AdminLayout>
    <div class="flex-1 flex flex-col h-full min-h-0">
      <header class="bg-white border-b border-slate-200 h-20 flex items-center px-8 justify-between shrink-0">
        <h1 class="text-xl font-bold text-brand-navy flex items-center gap-2">
          <SettingsIcon class="w-5 h-5 text-slate-400" />
          Site Settings
        </h1>
        <button @click="submit" :disabled="form.processing" class="bg-brand-indigo hover:bg-brand-hover text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center gap-2 shadow-sm transition-colors disabled:opacity-50">
          <Save class="w-4 h-4" />
          <span v-if="form.processing">Saving...</span>
          <span v-else>Save Changes</span>
        </button>
      </header>
      
      <main class="p-8 flex-1 overflow-y-auto bg-slate-50">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
          
          <div class="space-y-8">
            <!-- Contact Info Section -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
              <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-brand-navy">Contact Information</h3>
                <p class="text-sm text-slate-500 mb-6">These details will automatically update across the website header, footer, and contact page.</p>
                
                <div class="space-y-5">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Company Phone Number</label>
                    <input 
                      type="text" 
                      :value="getSettingValue('contact_phone')"
                      @input="e => updateSettingValue('contact_phone', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                      placeholder="e.g. 0722 000 000"
                    >
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Company Email Address</label>
                    <input 
                      type="email" 
                      :value="getSettingValue('contact_email')"
                      @input="e => updateSettingValue('contact_email', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                      placeholder="e.g. sales@dignitytraders.co.ke"
                    >
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Physical Address</label>
                    <textarea 
                      :value="getSettingValue('contact_address')"
                      @input="e => updateSettingValue('contact_address', e.target.value)"
                      rows="2"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                      placeholder="e.g. Nairobi, Kenya"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- Currency & Checkout Section -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
              <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-brand-navy">Currency & Checkout Settings</h3>
                <p class="text-sm text-slate-500 mb-6">Manage how currency conversions and cart limits behave across the shop.</p>
                
                <div class="space-y-5">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Online Payment Threshold (USD)</label>
                    <div class="text-xs text-slate-500 mb-2">If a customer's cart exceeds this limit, they will be forced to Request a Quote instead of paying online.</div>
                    <div class="relative">
                      <span class="absolute left-4 top-2 text-slate-400">$</span>
                      <input 
                        type="number" 
                        :value="getSettingValue('checkout_limit_usd')"
                        @input="e => updateSettingValue('checkout_limit_usd', e.target.value)"
                        class="w-full pl-8 pr-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="e.g. 5000"
                      >
                    </div>
                  </div>

                  <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-2">
                      <label class="block text-sm font-semibold text-slate-700">USD to KES Exchange Rate</label>
                      <button @click="syncCurrency" type="button" class="text-xs font-bold text-brand-indigo hover:text-brand-hover bg-indigo-50 px-3 py-1 rounded-full transition">
                        Sync from Market Now
                      </button>
                    </div>
                    <div class="text-xs text-slate-500 mb-2">The current active exchange rate used for all price conversions.</div>
                    <div class="relative">
                      <span class="absolute left-4 top-2 text-slate-400">KSH</span>
                      <input 
                        type="number" 
                        step="0.01"
                        :value="getSettingValue('exchange_rate_usd_to_kes')"
                        @input="e => updateSettingValue('exchange_rate_usd_to_kes', e.target.value)"
                        class="w-full pl-12 pr-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="e.g. 130"
                      >
                    </div>
                  </div>

                  <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                      <div class="relative">
                        <input 
                          type="checkbox" 
                          class="sr-only peer"
                          :checked="getSettingValue('auto_update_exchange_rate') === '1'"
                          @change="e => updateSettingValue('auto_update_exchange_rate', e.target.checked ? '1' : '0')"
                        >
                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-indigo"></div>
                      </div>
                      <div>
                        <span class="text-sm font-semibold text-slate-700 block">Auto-Update Exchange Rate</span>
                        <span class="text-xs text-slate-500 block">When enabled, the system automatically fetches the live market rate twice a day.</span>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-8">
            <!-- Email Configuration Section -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
              <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-brand-navy">Email Configuration</h3>
                <p class="text-sm text-slate-500 mb-6">Manage system email delivery settings directly without editing server files.</p>
                
                <div class="space-y-5">
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Mail Driver</label>
                    <select 
                      :value="getSettingValue('mail_driver') || 'smtp'"
                      @change="e => updateSettingValue('mail_driver', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo bg-white"
                    >
                      <option value="smtp">SMTP</option>
                      <option value="mailgun">Mailgun</option>
                      <option value="ses">Amazon SES</option>
                      <option value="postmark">Postmark</option>
                      <option value="sendmail">Sendmail</option>
                      <option value="log">Log (Local Testing)</option>
                    </select>
                    <div class="text-[10px] text-slate-400 mt-1">If using an API driver (Mailgun/SES), leave SMTP fields blank and configure via .env for API keys.</div>
                  </div>

                  <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                      <label class="block text-sm font-semibold text-slate-700 mb-1">Mail Host</label>
                      <input 
                        type="text" 
                        :value="getSettingValue('mail_host')"
                        @input="e => updateSettingValue('mail_host', e.target.value)"
                        class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="e.g. smtp.gmail.com"
                      >
                    </div>
                    <div>
                      <label class="block text-sm font-semibold text-slate-700 mb-1">SMTP Port</label>
                      <input 
                        type="text" 
                        :value="getSettingValue('mail_port')"
                        @input="e => updateSettingValue('mail_port', e.target.value)"
                        class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="e.g. 587 or 465"
                      >
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">SMTP Username</label>
                    <input 
                      type="text" 
                      :value="getSettingValue('mail_username')"
                      @input="e => updateSettingValue('mail_username', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                    >
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">SMTP Password</label>
                    <input 
                      type="password" 
                      :value="getSettingValue('mail_password')"
                      @input="e => updateSettingValue('mail_password', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                    >
                  </div>

                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-semibold text-slate-700 mb-1">Encryption</label>
                      <input 
                        type="text" 
                        :value="getSettingValue('mail_encryption')"
                        @input="e => updateSettingValue('mail_encryption', e.target.value)"
                        class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="tls or ssl"
                      >
                    </div>
                    <div>
                      <label class="block text-sm font-semibold text-slate-700 mb-1">From Name</label>
                      <input 
                        type="text" 
                        :value="getSettingValue('mail_from_name')"
                        @input="e => updateSettingValue('mail_from_name', e.target.value)"
                        class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                        placeholder="e.g. Dignity Traders"
                      >
                    </div>
                  </div>
                  
                  <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">From Address</label>
                    <input 
                      type="email" 
                      :value="getSettingValue('mail_from_address')"
                      @input="e => updateSettingValue('mail_from_address', e.target.value)"
                      class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:border-brand-indigo focus:ring-1 focus:ring-brand-indigo"
                      placeholder="e.g. no-reply@dignitytraders.co.ke"
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </AdminLayout>
</template>
