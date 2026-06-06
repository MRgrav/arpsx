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

      <div v-if="Object.keys(form.errors).length > 0" class="p-4 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-sm flex items-start gap-3 shadow-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="space-y-1">
          <p class="font-semibold">Please correct the following errors:</p>
          <ul class="list-disc pl-5 space-y-0.5">
            <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
          </ul>
        </div>
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
                <p class="text-xs text-gray-400 dark:text-gray-500">Enable standard application form</p>
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
                <p class="text-xs text-gray-400 dark:text-gray-500">Enable High School application form</p>
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

    </div>
  </SchoolAdminLayout>
</template>
