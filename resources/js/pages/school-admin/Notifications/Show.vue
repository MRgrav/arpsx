<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type Notification, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import { Calendar, ArrowLeft, Paperclip, FileText, Image as ImageIcon, Download, ExternalLink, Edit } from 'lucide-vue-next';

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
 * Resolve a link to a usable URL.
 */
const resolveUrl = (link: any): string => {
  if (!link) return '#';
  if (typeof link === 'object' && link.url) return link.url;
  return typeof link === 'string' ? link : '#';
};

/**
 * Determine if a file link is PDF or Image
 */
const getFileType = (link: { url: string; type?: string }): 'pdf' | 'image' => {
  if (link.type === 'pdf') return 'pdf';
  if (link.type === 'image') return 'image';
  const url = link.url.toLowerCase();
  if (url.endsWith('.pdf') || url.includes('pdf')) return 'pdf';
  return 'image';
};
</script>

<template>
  <Head :title="`Notification - ${props.notification.title}`" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="container mx-auto space-y-6">
      
      <!-- Main Content Card -->
      <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 md:p-8 shadow-sm space-y-6">
        
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 dark:border-gray-800 pb-5">
          <div class="space-y-1">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
              {{ props.notification.title }}
            </h1>
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
              <Calendar class="size-3.5" />
              <span>
                Created at: {{
                  new Date(props.notification.created_at).toLocaleString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                  })
                }}
              </span>
            </div>
          </div>

          <div class="flex gap-2 shrink-0">
            <Link :href="`/school-admin/notifications/${props.notification.id}/edit`">
              <Button class="bg-indigo-600 hover:bg-indigo-700 text-white flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-lg shadow-xs">
                <Edit class="size-4" />
                Edit Notice
              </Button>
            </Link>
          </div>
        </div>

        <!-- Message Body -->
        <div
          class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed text-base whitespace-pre-line bg-gray-50/70 dark:bg-gray-800/40 p-5 rounded-xl border border-gray-100 dark:border-gray-800"
          v-html="props.notification.message || 'No message provided.'"
        ></div>

        <!-- Attachments & Media Section -->
        <div v-if="props.notification.links && props.notification.links.length" class="space-y-6 border-t border-gray-100 dark:border-gray-800 pt-6">
          <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
            <Paperclip class="size-4 text-indigo-600 dark:text-indigo-400" />
            Attachments ({{ props.notification.links.length }})
          </h2>

          <div v-for="(link, index) in props.notification.links" :key="index" class="space-y-4 bg-gray-50/80 dark:bg-gray-950/50 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-4 md:p-6 shadow-xs">
            
            <!-- Attachment Control Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-white dark:bg-gray-900 p-3.5 rounded-xl border border-gray-200/60 dark:border-gray-800">
              <div class="flex items-center gap-2.5 min-w-0">
                <FileText v-if="getFileType(link) === 'pdf'" class="size-5 text-red-500 shrink-0" />
                <ImageIcon v-else class="size-5 text-emerald-500 shrink-0" />
                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                  Attachment #{{ index + 1 }} ({{ getFileType(link).toUpperCase() }})
                </span>
              </div>

              <div class="flex items-center gap-2 shrink-0">
                <button
                  type="button"
                  @click="openLightbox(resolveUrl(link.url), getFileType(link))"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition"
                >
                  <ExternalLink class="size-3.5" />
                  Expand View
                </button>

                <a
                  :href="resolveUrl(link.url)"
                  target="_blank"
                  download
                  class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition active:scale-95"
                >
                  <Download class="size-3.5" />
                  Download File
                </a>
              </div>
            </div>

            <!-- PDF Embedded Viewer -->
            <template v-if="getFileType(link) === 'pdf'">
              <div class="w-full h-[calc(100vh-220px)] min-h-[500px] rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800 shadow-xs bg-white">
                <iframe :src="resolveUrl(link.url)" class="w-full h-full border-0" title="PDF Attachment Viewer"></iframe>
              </div>
            </template>

            <!-- Image Embedded Viewer -->
            <template v-else>
              <div class="w-full rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800 bg-black/5 dark:bg-black/40 p-3 flex justify-center items-center">
                <img
                  :src="resolveUrl(link.url)"
                  alt="Notice Image Attachment"
                  class="max-h-[75vh] w-auto object-contain rounded-lg shadow-md cursor-pointer hover:opacity-95 transition"
                  @click="openLightbox(resolveUrl(link.url), 'image')"
                />
              </div>
            </template>
          </div>
        </div>

        <!-- Back Button -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
          <Link href="/school-admin/notifications">
            <Button variant="secondary" class="flex items-center gap-2">
              <ArrowLeft class="size-4" />
              Back to Notifications
            </Button>
          </Link>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <Teleport to="body">
      <div
        v-if="lightboxSrc"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4"
        @click.self="closeLightbox"
      >
        <div class="relative w-full max-w-6xl h-full max-h-[92vh] flex flex-col items-center justify-center">
          <button
            class="absolute -top-12 right-0 text-white bg-white/20 hover:bg-white/40 rounded-full w-9 h-9 flex items-center justify-center font-bold transition z-50"
            @click="closeLightbox"
          >✕</button>
          
          <template v-if="lightboxType === 'image'">
            <img
              :src="lightboxSrc"
              alt="Full size attachment"
              class="max-h-full max-w-full rounded-xl shadow-2xl object-contain"
            />
          </template>

          <template v-else-if="lightboxType === 'pdf'">
            <iframe
              :src="lightboxSrc"
              class="w-full h-full rounded-xl bg-white shadow-2xl"
              frameborder="0"
            ></iframe>
          </template>
        </div>
      </div>
    </Teleport>
  </SchoolAdminLayout>
</template>
