<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import { type Notification } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Bell, Calendar, ArrowRight } from 'lucide-vue-next';

interface Props {
  notifications: Notification[]
}

const props = defineProps<Props>();

const formatDate = (dateVal: string | Date) => {
  return new Date(dateVal).toLocaleString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>

<template>
  <AppLayout>
    <PageHeadIndi heading="Notifications" />
    
    <div class="max-w-4xl mx-auto py-12 px-6">
      <div v-if="props.notifications.length === 0" class="text-center py-16 bg-white/50 backdrop-blur-md rounded-2xl border border-blue-100 p-8 shadow-sm">
        <Bell class="mx-auto size-12 text-blue-300 stroke-[1.5] mb-4" />
        <p class="text-gray-500 font-medium">No new notifications at this time.</p>
      </div>

      <div v-else class="space-y-6">
        <Link
          v-for="notification in props.notifications"
          :key="notification.id"
          :href="`/notifications/${notification.id}`"
          class="group relative flex gap-5 border border-blue-100/70 rounded-2xl p-6 shadow-xs bg-white/60 backdrop-blur-md hover:shadow-md hover:border-blue-300/80 transition duration-300 block overflow-hidden"
        >
          <!-- Accent Colored Bar -->
          <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-gradient-to-b from-blue-500 to-indigo-600"></div>

          <!-- Notification Icon Badge -->
          <div class="hidden sm:flex shrink-0 w-12 h-12 rounded-full bg-blue-50 border border-blue-100 items-center justify-center text-blue-600 group-hover:scale-110 transition duration-300">
            <Bell class="size-5 stroke-[2]" />
          </div>

          <!-- Main Info -->
          <div class="flex-1 min-w-0">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
              <h2 class="text-lg font-bold text-blue-900 group-hover:text-blue-700 transition truncate">
                {{ notification.title }}
              </h2>
              
              <!-- Date Badge -->
              <span class="inline-flex items-center gap-1.5 text-xs text-blue-600/85 font-semibold bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100 shrink-0 w-fit">
                <Calendar class="size-3.5" />
                {{ formatDate(notification.created_at) }}
              </span>
            </div>
            
            <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
              {{ notification.message }}
            </p>
            
            <div class="mt-4 flex items-center gap-1 text-xs font-bold text-blue-600 group-hover:text-blue-800 transition">
              Read Details
              <ArrowRight class="size-3.5 group-hover:translate-x-1 transition" />
            </div>
          </div>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
