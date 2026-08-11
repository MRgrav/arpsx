<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';

interface SettingsData {
  registration_enabled: boolean;
  hs_registration_enabled: boolean;
  registration_message: string;
  hs_registration_message: string;
  registration_classes: string[];
  registration_categories: string[];
  registration_defence_categories: string[];
  flash_update_enabled: boolean;
  flash_update_image: string;
  flash_update_image_mobile: string;
}

const props = defineProps<{
  settings: SettingsData;
}>();

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
const flashError = computed(() => page.props.flash?.error);

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Settings', href: '/school-admin/settings' },
];

const fileInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);

const form = useForm({
  registration_enabled: props.settings.registration_enabled,
  hs_registration_enabled: props.settings.hs_registration_enabled,
  flash_update_enabled: props.settings.flash_update_enabled,
  flash_update_image_file: null as File | null,
});

const configForm = useForm({
  registration_message: props.settings.registration_message || '',
  hs_registration_message: props.settings.hs_registration_message || '',
  registration_classes: props.settings.registration_classes || [],
  registration_categories: props.settings.registration_categories || [],
  registration_defence_categories: props.settings.registration_defence_categories || [],
});

const allClasses = ["Nursery", "LKG", "UKG", "CLASS I", "CLASS II", "CLASS III", "CLASS IV", "CLASS V", "CLASS VI", "CLASS VII", "CLASS VIII", "CLASS IX", "CLASS X", "CLASS XI", "CLASS XII"];
const allCategories = ["GENERAL", "SC", "ST", "OBC-A", "OBC-B"];
const allDefenceCategories = ["CIVILIAN", "DEFENCE AR", "DEFENCE CRPS", "DEFENCE AFS", "DEFENCE ARMY", "DEFENCE OTHERS", "RETIRED DEFENCE"];

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    form.flash_update_image_file = file;
    if (imagePreview.value) {
      URL.revokeObjectURL(imagePreview.value);
    }
    imagePreview.value = URL.createObjectURL(file);
  }
};

const toggleRegistration = () => {
  form.registration_enabled = !form.registration_enabled;
  submitToggle('registration_enabled', form.registration_enabled);
};

const toggleHSRegistration = () => {
  form.hs_registration_enabled = !form.hs_registration_enabled;
  submitToggle('hs_registration_enabled', form.hs_registration_enabled);
};

const toggleFlashUpdate = () => {
  form.flash_update_enabled = !form.flash_update_enabled;
  submitToggle('flash_update_enabled', form.flash_update_enabled);
};

const submitToggle = (key: string, value: boolean) => {
  router.post(route('school-admin.settings.toggle'), { key, value }, {
    preserveScroll: true,
  });
};

const saveSettings = () => {
  form.post(route('school-admin.settings.update'), {
    onSuccess: () => {
      imagePreview.value = null;
      if (fileInput.value) fileInput.value.value = '';
    },
    preserveScroll: true,
  });
};

const saveConfigs = () => {
  configForm.post(route('school-admin.settings.update'), {
    preserveScroll: true,
  });
};
</script>

<template>
  <Head title="System Settings" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
      
      <!-- Page Header -->
      <div class="flex flex-col gap-1 border-b border-gray-100 dark:border-gray-800 pb-5">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">System Settings</h1>
        <p class="text-gray-500 dark:text-gray-400">Manage registration portal statuses and dynamic homepage flash banners.</p>
      </div>

      <!-- Success/Error Alert Messages -->
      <div v-if="flashSuccess" class="p-4 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm flex items-start gap-3 shadow-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ flashSuccess }}</span>
      </div>

      <div v-if="flashError" class="p-4 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm flex items-start gap-3 shadow-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ flashError }}</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Registration Control Card -->
        <div class="md:col-span-1 space-y-4">
          <div class="bg-white dark:bg-gray-950 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 shadow-sm space-y-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
              </svg>
              Portal Statuses
            </h2>
            
            <!-- Standard Registration Toggle -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-50 dark:border-gray-900">
              <div class="space-y-0.5">
                <Label class="text-sm font-semibold text-gray-800 dark:text-gray-200">Online Registration</Label>
                <p class="text-xs text-gray-400 dark:text-gray-500">Enable standard form</p>
              </div>
              <button
                type="button"
                @click="toggleRegistration"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                :class="form.registration_enabled ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-800'"
              >
                <span
                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                  :class="form.registration_enabled ? 'translate-x-5' : 'translate-x-0'"
                />
              </button>
            </div>

            <!-- HS Registration Toggle -->
            <div class="flex items-center justify-between">
              <div class="space-y-0.5">
                <Label class="text-sm font-semibold text-gray-800 dark:text-gray-200">HS Registration</Label>
                <p class="text-xs text-gray-400 dark:text-gray-500">Enable High School form</p>
              </div>
              <button
                type="button"
                @click="toggleHSRegistration"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                :class="form.hs_registration_enabled ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-800'"
              >
                <span
                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                  :class="form.hs_registration_enabled ? 'translate-x-5' : 'translate-x-0'"
                />
              </button>
            </div>
          </div>
        </div>

        <!-- Flash Update Management Card -->
        <div class="md:col-span-2 space-y-6">
          <div class="bg-white dark:bg-gray-950 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-gray-50 dark:border-gray-900 pb-4">
              <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Dynamic Flash Banner
              </h2>
              <button
                type="button"
                @click="toggleFlashUpdate"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                :class="form.flash_update_enabled ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-800'"
              >
                <span
                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                  :class="form.flash_update_enabled ? 'translate-x-5' : 'translate-x-0'"
                />
              </button>
            </div>

            <!-- Image upload form -->
            <form @submit.prevent="saveSettings" class="space-y-6">
              
              <!-- Banner Preview -->
              <div class="space-y-2">
                <Label>Current Active Banner</Label>
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-3 bg-gray-50 dark:bg-gray-900 space-y-2">
                  <span class="text-xs font-semibold text-gray-500 uppercase">Banner Image Preview (Optimized WebP)</span>
                  <div class="aspect-video w-full rounded-lg overflow-hidden bg-zinc-800 flex items-center justify-center">
                    <img 
                      v-if="imagePreview" 
                      :src="imagePreview" 
                      class="w-full h-full object-contain" 
                    />
                    <img 
                      v-else-if="settings.flash_update_image" 
                      :src="settings.flash_update_image" 
                      class="w-full h-full object-contain" 
                    />
                    <span v-else class="text-xs text-gray-400">Default image active</span>
                  </div>
                </div>
              </div>

              <!-- Upload field -->
              <div class="space-y-2">
                <Label for="banner_upload">Upload New Banner</Label>
                <Input 
                  id="banner_upload" 
                  type="file" 
                  ref="fileInput"
                  accept="image/png, image/jpeg, image/jpg"
                  @change="handleFileSelect"
                  class="cursor-pointer file:text-indigo-600 hover:file:text-indigo-700" 
                />
                <p class="text-xs text-gray-400">Upload a horizontal PNG or JPEG banner. It will be converted to high-performance WebP versions automatically.</p>
              </div>

              <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-900">
                <Button 
                  type="submit" 
                  class="bg-indigo-600 hover:bg-indigo-700 text-white min-w-[150px]"
                  :disabled="form.processing || !form.flash_update_image_file"
                >
                  {{ form.processing ? 'Uploading...' : 'Upload & Save' }}
                </Button>
              </div>
            </form>

          </div>
        </div>

      </div>

      <!-- Registration Form Configurations Card -->
      <div class="bg-white dark:bg-gray-950 p-6 rounded-2xl border border-gray-100 dark:border-gray-800/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-gray-50 dark:border-gray-900 pb-4">
          <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
            Registration Dynamic Configurations
          </h2>
        </div>

        <form @submit.prevent="saveConfigs" class="space-y-8">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Notices -->
            <div class="space-y-2">
              <Label for="reg_msg">Standard Registration Notice Message</Label>
              <Input id="reg_msg" v-model="configForm.registration_message" placeholder="e.g. Admission Closed for 2026 session." />
              <p class="text-xs text-gray-500">Displayed when form is disabled.</p>
            </div>
            
            <div class="space-y-2">
              <Label for="hs_msg">HS Registration Notice Message</Label>
              <Input id="hs_msg" v-model="configForm.hs_registration_message" placeholder="e.g. Admission Closed for 2026 session." />
              <p class="text-xs text-gray-500">Displayed when HS form is disabled.</p>
            </div>
          </div>

          <!-- Classes Checkboxes -->
          <div class="space-y-3">
            <Label class="text-base font-semibold">Available Classes for Admission</Label>
            <p class="text-sm text-gray-500">Select which classes will appear in the registration form dropdown.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100">
              <div v-for="cls in allClasses" :key="cls" class="flex items-center space-x-2">
                <input 
                  type="checkbox" 
                  :id="cls" 
                  :value="cls" 
                  v-model="configForm.registration_classes"
                  class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                >
                <label :for="cls" class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ cls }}</label>
              </div>
            </div>
          </div>

          <!-- Categories Checkboxes -->
          <div class="space-y-3">
            <Label class="text-base font-semibold">Available Social Categories</Label>
            <div class="flex flex-wrap gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100">
              <div v-for="cat in allCategories" :key="cat" class="flex items-center space-x-2">
                <input 
                  type="checkbox" 
                  :id="cat" 
                  :value="cat" 
                  v-model="configForm.registration_categories"
                  class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                >
                <label :for="cat" class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ cat }}</label>
              </div>
            </div>
          </div>

          <!-- Defence Categories Checkboxes -->
          <div class="space-y-3">
            <Label class="text-base font-semibold">Available Parent Categories</Label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100">
              <div v-for="def in allDefenceCategories" :key="def" class="flex items-center space-x-2">
                <input 
                  type="checkbox" 
                  :id="def" 
                  :value="def" 
                  v-model="configForm.registration_defence_categories"
                  class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                >
                <label :for="def" class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ def }}</label>
              </div>
            </div>
          </div>

          <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-900">
            <Button 
              type="submit" 
              class="bg-indigo-600 hover:bg-indigo-700 text-white min-w-[200px]"
              :disabled="configForm.processing"
            >
              {{ configForm.processing ? 'Saving...' : 'Save Configurations' }}
            </Button>
          </div>
        </form>
      </div>

    </div>
  </SchoolAdminLayout>
</template>
