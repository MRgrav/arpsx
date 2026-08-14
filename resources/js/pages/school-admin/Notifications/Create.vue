<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onUnmounted } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Notifications', href: '/school-admin/notifications' },
  { title: 'Create', href: '/school-admin/notifications/create' },
];

interface SelectedFile {
  file: File;
  type: 'pdf' | 'image';
  preview: string | null; // blob URL for images, null for PDFs
}

const selectedFiles = ref<SelectedFile[]>([]);

const form = useForm({
  title: '',
  message: '',
  files: [] as File[],
});

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (!target.files) return;

  // Revoke old object URLs to avoid memory leaks
  selectedFiles.value.forEach(sf => {
    if (sf.preview) URL.revokeObjectURL(sf.preview);
  });

  selectedFiles.value = Array.from(target.files).map(file => {
    const isPdf = file.type === 'application/pdf';
    return {
      file,
      type: isPdf ? 'pdf' : 'image',
      preview: isPdf ? null : URL.createObjectURL(file),
    };
  });

  form.files = selectedFiles.value.map(sf => sf.file);
};

const removeFile = (index: number) => {
  const sf = selectedFiles.value[index];
  if (sf.preview) URL.revokeObjectURL(sf.preview);
  selectedFiles.value.splice(index, 1);
  form.files = selectedFiles.value.map(sf => sf.file);
};

// Clean up blob URLs when the component unmounts
onUnmounted(() => {
  selectedFiles.value.forEach(sf => {
    if (sf.preview) URL.revokeObjectURL(sf.preview);
  });
});

const submit = () => {
  form.post('/school-admin/notifications');
};
</script>

<template>
  <Head title="Create Notification" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="container mx-auto bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create Notification</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Send a new notification with optional file attachments.</p>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="space-y-2">
          <Label for="title">Title</Label>
          <Input id="title" v-model="form.title" placeholder="Enter notification title" />
          <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
        </div>

        <div class="space-y-2">
          <Label for="message">Message</Label>
          <RichTextEditor v-model="form.message" placeholder="Enter notification message" />
          <div v-if="form.errors.message" class="text-red-500 text-sm mt-1">{{ form.errors.message }}</div>
        </div>

        <div class="space-y-2">
          <Label for="files">Attachments (PDF or Images)</Label>
          <div class="mt-1">
            <input
              id="files"
              type="file"
              multiple
              accept=".pdf,.jpg,.jpeg,.png"
              @change="handleFileSelect"
              class="block w-full text-sm text-gray-500 dark:text-gray-400
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100 dark:file:bg-gray-800 dark:file:text-gray-300"
            />
          </div>
          <p class="text-xs text-gray-500 mt-1">You can select multiple files. Max 2MB per file.</p>

          <!-- Selected files preview -->
          <div v-if="selectedFiles.length" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div
              v-for="(sf, index) in selectedFiles"
              :key="index"
              class="relative group rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-800"
            >
              <!-- Image preview -->
              <img
                v-if="sf.type === 'image' && sf.preview"
                :src="sf.preview"
                class="w-full h-28 object-cover"
                :alt="sf.file.name"
              />

              <!-- PDF badge -->
              <div
                v-else
                class="w-full h-28 flex flex-col items-center justify-center gap-2 bg-red-50 dark:bg-red-900/20"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                  <polyline points="14 2 14 8 20 8"/>
                  <line x1="9" y1="13" x2="15" y2="13"/>
                  <line x1="9" y1="17" x2="15" y2="17"/>
                </svg>
                <span class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wide">PDF</span>
              </div>

              <!-- File name + size footer -->
              <div class="px-2 py-1.5 text-xs text-gray-600 dark:text-gray-300 truncate">
                <span class="font-medium truncate block">{{ sf.file.name }}</span>
                <span class="text-gray-400">{{ (sf.file.size / 1024).toFixed(1) }} KB</span>
              </div>

              <!-- Remove button -->
              <button
                type="button"
                @click="removeFile(index)"
                class="absolute top-1 right-1 bg-white/80 dark:bg-gray-900/80 rounded-full p-0.5 text-gray-500 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                title="Remove"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>

          <div v-if="form.errors.files" class="text-red-500 text-sm mt-1">{{ form.errors.files }}</div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
          <Link href="/school-admin/notifications">
            <Button variant="outline">Cancel</Button>
          </Link>
          <Button
            type="submit"
            class="min-w-[150px]"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Creating...' : 'Create Notification' }}
          </Button>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
