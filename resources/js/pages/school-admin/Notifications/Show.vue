<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type Notification, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';

const props = defineProps<{ notification: Notification }>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Notifications', href: '/school-admin/notifications' },
  { title: 'View Notification', href: `/school-admin/notifications/${props.notification.id}` },
];

/** Lightbox state */
const lightboxSrc = ref<string | null>(null);
const lightboxType = ref<'image' | 'pdf' | null>(null);

const openLightbox = (src: string, type: 'image' | 'pdf') => {
  lightboxSrc.value = src;
  lightboxType.value = type;
};

const closeLightbox = () => {
  lightboxSrc.value = null;
  lightboxType.value = null;
};

/**
 * Returns true if the URL points to a PDF.
 */
const isPdf = (url: string): boolean =>
  url.toLowerCase().split('?')[0].endsWith('.pdf');

/**
 * Resolve a link to a usable URL.
 */
const resolveUrl = (link: string): string => {
  try {
    new URL(link);
    return link;
  } catch {
    return `/storage/notifications/${link}`;
  }
};
</script>

<template>
  <Head :title="`Notification - ${props.notification.title}`" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 space-y-6">

      <!-- Header -->
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
          {{ props.notification.title }}
        </h1>
        <div class="flex gap-2">
            <Link :href="`/school-admin/notifications/${props.notification.id}/edit`">
                <Button>Edit</Button>
            </Link>
        </div>
      </div>

      <!-- Message -->
      <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
        {{ props.notification.message || 'No message provided.' }}
      </div>

      <!-- Attachments / Links -->
      <div v-if="props.notification.links && props.notification.links.length" class="space-y-3">
        <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">
          Attachments
        </h2>

        <div class="flex flex-wrap gap-4">
          <template v-for="(link, index) in props.notification.links" :key="index">
            <!-- PDF -->
            <!-- <template v-if="isPdf(link)"> -->
              <div class="flex flex-col gap-1">
                <button
                  type="button"
                  @click="openLightbox(resolveUrl(link.url), link.type)"
                  class="flex capitalize items-center gap-2 px-3 py-2 rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 transition text-sm font-medium"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="9" y1="13" x2="15" y2="13"/>
                    <line x1="9" y1="17" x2="15" y2="17"/>
                  </svg>
                  View {{ link.type }} {{ index + 1 }}
                </button>
                <a :href="resolveUrl(link.url)" target="_blank" class="text-[10px] text-gray-500 hover:underline px-1">
                    Download / Open in new tab
                </a>
              </div>
            <!-- </template> -->

            <!-- Image -->
            <!-- <template v-else> -->
              <!-- <img
                :src="resolveUrl(link)"
                :alt="`Attachment ${index + 1}`"
                class="h-28 w-auto rounded-lg border border-gray-200 shadow-sm cursor-pointer hover:opacity-80 transition object-cover"
                @click="openLightbox(resolveUrl(link), 'image')"
              /> -->
            <!-- </template> -->

          </template>
        </div>
      </div>

      <!-- Created at -->
      <div class="text-sm text-gray-500 dark:text-gray-400">
        Created at:
        {{
          new Date(props.notification.created_at).toLocaleString('en-CA', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
          })
        }}
      </div>

      <!-- Back button -->
      <div class="pt-2">
        <Link href="/school-admin/notifications">
          <Button variant="secondary">← Back to Notifications</Button>
        </Link>
      </div>
    </div>

    <!-- Lightbox modal -->
    <Teleport to="body">
      <div
        v-if="lightboxSrc"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-sm p-4"
        @click.self="closeLightbox"
      >
        <div class="relative w-full max-w-5xl h-full max-h-[90vh] flex flex-col items-center justify-center">
          <button
            class="absolute -top-10 right-0 text-white bg-black/50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/80 transition z-50"
            @click="closeLightbox"
          >✕</button>
          
          <template v-if="lightboxType === 'image'">
            <img
              :src="lightboxSrc"
              alt="Full size attachment"
              class="max-h-full max-w-full rounded-lg shadow-2xl object-contain"
            />
          </template>

          <template v-else-if="lightboxType === 'pdf'">
            <iframe
                :src="lightboxSrc"
                class="w-full h-full rounded-lg bg-white shadow-2xl"
                frameborder="0"
            ></iframe>
          </template>
        </div>
      </div>
    </Teleport>
  </SchoolAdminLayout>
</template>
