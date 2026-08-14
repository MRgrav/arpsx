<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type Notification, type NotificationAttachment, type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, onUnmounted } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';

const props = defineProps<{ notification: Notification }>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Notifications', href: '/school-admin/notifications' },
  { title: 'Edit', href: `/school-admin/notifications/${props.notification.id}/edit` },
];

interface SelectedFile {
  file: File;
  type: 'pdf' | 'image';
  preview: string | null;
}

// Keep existing links in a plain ref so we can mutate freely
const existingLinks = ref<NotificationAttachment[]>([...(props.notification.links ?? [])]);

// New files selected by the user
const selectedFiles = ref<SelectedFile[]>([]);

/**
 * We use standard form submission logic.
 * Note: PHP has trouble parsing multipart/form-data on PUT/PATCH requests.
 * Inertia's `form.post` with `_method: 'put'` manually injected handles this.
 */
const form = useForm({
  _method: 'put' as const,
  title: props.notification.title,
  message: props.notification.message ?? '',
  files: [] as File[],
});

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (!target.files) return;

  // Revoke previous blob URLs to avoid memory leaks
  selectedFiles.value.forEach(sf => {
    if (sf.preview) URL.revokeObjectURL(sf.preview);
  });

  selectedFiles.value = Array.from(target.files).map(file => {
    const isPdf = file.type === 'application/pdf';
    return {
      file,
      type: isPdf ? 'pdf' : 'image',
      preview: isPdf ? null : URL.createObjectURL(file),
    } as SelectedFile;
  });
};

const removeNewFile = (index: number) => {
  const entry = selectedFiles.value[index];
  if (entry.preview) URL.revokeObjectURL(entry.preview);
  selectedFiles.value.splice(index, 1);
};

const removeExistingLink = (index: number) => {
  existingLinks.value.splice(index, 1);
};

onUnmounted(() => {
  selectedFiles.value.forEach(sf => {
    if (sf.preview) URL.revokeObjectURL(sf.preview);
  });
});

const submit = () => {
  // Build a plain FormData-compatible object and submit
  // We use POST with _method: 'put' for multipart support in PHP
  const data: Record<string, unknown> = {
    _method: 'put',
    title: form.title,
    message: form.message,
    links: existingLinks.value,
  };

  // Attach new files
  selectedFiles.value.forEach((sf, i) => {
    (data as Record<string, unknown>)[`files[${i}]`] = sf.file;
  });

  form.transform(() => data).post(`/school-admin/notifications/${props.notification.id}`, {
    preserveScroll: true,
  });
};
</script>

<template>
  <Head :title="`Edit Notification - ${props.notification.title}`" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Notification</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Update the notification details and manage attachments.</p>
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

        <!-- Existing Attachments -->
        <div v-if="existingLinks.length" class="space-y-3">
          <Label>Existing Attachments</Label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div
              v-for="(link, index) in existingLinks"
              :key="index"
              class="relative group rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-800"
            >
              <!-- Image preview -->
              <img
                v-if="link.type === 'image'"
                :src="link.url"
                class="w-full h-28 object-cover"
                :alt="link.url.split('/').pop()"
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

              <!-- File name footer -->
              <div class="px-2 py-1.5 text-xs text-gray-600 dark:text-gray-300 truncate">
                <span class="font-medium truncate block">{{ link.url.split('/').pop() }}</span>
                <span class="text-gray-400 uppercase">{{ link.type }}</span>
              </div>

              <!-- Remove button -->
              <button
                type="button"
                @click="removeExistingLink(index)"
                class="absolute top-1 right-1 bg-white/80 dark:bg-gray-900/80 rounded-full p-0.5 text-gray-500 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                title="Remove attachment"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- New Attachments -->
        <div class="space-y-2">
          <Label for="files">Add New Attachments (PDF/Images)</Label>
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

          <!-- New file previews -->
          <div v-if="selectedFiles.length" class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div
              v-for="(sf, index) in selectedFiles"
              :key="index"
              class="relative group rounded-lg border border-blue-200 dark:border-blue-800 overflow-hidden bg-gray-50 dark:bg-gray-800"
            >
              <img
                v-if="sf.type === 'image' && sf.preview"
                :src="sf.preview"
                class="w-full h-28 object-cover"
                :alt="sf.file.name"
              />
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
              <div class="px-2 py-1.5 text-xs text-gray-600 dark:text-gray-300 truncate">
                <span class="font-medium truncate block">{{ sf.file.name }}</span>
                <span class="text-gray-400">{{ (sf.file.size / 1024).toFixed(1) }} KB · NEW</span>
              </div>
              <button
                type="button"
                @click="removeNewFile(index)"
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
          <Link :href="`/school-admin/notifications/${props.notification.id}`">
            <Button variant="outline">Cancel</Button>
          </Link>
          <Button
            type="submit"
            class="min-w-[150px]"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Updating...' : 'Update Notification' }}
          </Button>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
