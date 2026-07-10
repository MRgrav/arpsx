<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Bell, Sparkles } from 'lucide-vue-next';
import type { Notification } from '@/types';

interface Props {
  notifications: Notification[];
}

const props = defineProps<Props>();
</script>

<template>
  <div v-if="props.notifications && props.notifications.length > 0" class="relative flex items-center bg-slate-950/60 backdrop-blur-md border-y border-white/10 h-12 overflow-hidden shadow-[inset_0_2px_4px_rgba(0,0,0,0.3),_0_10px_30px_rgba(0,0,0,0.15)] z-20">
    <!-- Live Ticker Badge with 3D gradient and status pulse -->
    <div class="relative z-30 flex items-center h-full bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 px-6 text-white text-xs font-black uppercase tracking-widest shadow-[5px_0_15px_rgba(0,0,0,0.4)] rounded-r-2xl border-r border-white/10 flex-shrink-0">
      <span class="relative flex h-2 w-2 mr-2.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
      </span>
      <Bell class="w-3.5 h-3.5 mr-1.5 animate-bounce" />
      Latest Updates
    </div>
    
    <!-- Scrolling Track -->
    <div class="relative w-full overflow-hidden flex items-center h-full px-4">
      <div class="marquee-track flex gap-16 items-center whitespace-nowrap">
        <!-- Duplicate content twice to ensure seamless looping -->
        <div v-for="loop in 2" :key="loop" class="marquee-content flex gap-16 items-center">
          <Link
            v-for="item in props.notifications"
            :key="item.id + '-' + loop"
            :href="`/notifications/${item.id}`"
            class="flex items-center gap-2 text-white/90 hover:text-[#ffeb00] font-semibold text-sm transition-all duration-300 hover:scale-105 shrink-0"
          >
            <Sparkles class="w-4 h-4 text-amber-400 flex-shrink-0" />
            <span>{{ item.title }}</span>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.marquee-track {
  display: flex;
  width: max-content;
}

.marquee-track:hover .marquee-content {
  animation-play-state: paused;
}

.marquee-content {
  display: flex;
  gap: 4rem; /* Match spacing gap-16 */
  align-items: center;
  animation: marquee-scroll 30s linear infinite;
  padding-right: 4rem;
}

@keyframes marquee-scroll {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
}
</style>
