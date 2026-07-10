<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import { type Notification } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Bell, Calendar, ArrowLeft, Paperclip, FileText, Download } from 'lucide-vue-next';

const props = defineProps<{ notification: Notification }>();

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
  <AppLayout>
    <Head :title="`Notification - ${props.notification.title}`" />
    <PageHeadIndi heading="Notification Details" />
    
    <div class="max-w-4xl mx-auto py-12 px-6">
      <div class="bg-white/70 backdrop-blur-md rounded-2xl border border-blue-100 p-8 shadow-sm relative overflow-hidden">
        <!-- Accent Colored Bar -->
        <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-gradient-to-b from-blue-500 to-indigo-600"></div>

        <!-- Date & Badge header -->
        <div class="flex items-center justify-between border-b border-blue-100/60 pb-4 mb-6">
          <div class="flex items-center gap-2 text-xs text-blue-600 font-semibold bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
            <Calendar class="size-3.5" />
            <span>
              {{
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
          
          <span class="inline-flex items-center gap-1.5 text-xs text-indigo-700 font-bold bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100">
            <Bell class="size-3.5" />
            Official Notice
          </span>
        </div>

        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-extrabold text-blue-900 mb-6 leading-tight">
          {{ props.notification.title }}
        </h1>

        <!-- Content Message -->
        <div class="text-gray-700 leading-relaxed font-serif text-justify mb-8 whitespace-pre-line">
          {{ props.notification.message || 'No message content provided.' }}
        </div>

        <!-- Attachments / Links Section -->
        <div v-if="props.notification.links && props.notification.links.length" class="border-t border-blue-100/60 pt-6 mt-6 space-y-4">
          <h3 class="text-xs font-bold text-blue-900 uppercase tracking-widest flex items-center gap-2">
            <Paperclip class="size-4 text-blue-600" />
            Attachments & Downloads
          </h3>

          <div class="flex flex-wrap gap-4">
            <div v-for="(link, index) in props.notification.links" :key="index" class="flex flex-col gap-1.5 bg-blue-50/50 border border-blue-100/50 p-3 rounded-xl min-w-[200px]">
              <button
                type="button"
                @click="openLightbox(resolveUrl(link.url), link.type)"
                class="flex capitalize items-center gap-2 px-4 py-2 rounded-lg border border-blue-200 bg-white text-blue-700 hover:bg-blue-50 transition text-sm font-semibold shadow-xs"
              >
                <FileText class="size-4 shrink-0 text-blue-500" />
                View Attachment
              </button>
              
              <a :href="resolveUrl(link.url)" target="_blank" download class="text-[11px] text-blue-600 hover:underline px-1 font-medium text-center">
                Download Direct
              </a>
            </div>
          </div>
        </div>

        <!-- Back Navigation Button -->
        <div class="border-t border-blue-100/60 pt-6 mt-8">
          <Link href="/notifications">
            <Button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold flex items-center gap-2 px-5 py-2.5 rounded-xl transition active:scale-95 shadow-sm">
              <ArrowLeft class="size-4" />
              Back to Notifications
            </Button>
          </Link>
        </div>
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
  </AppLayout>
</template>
