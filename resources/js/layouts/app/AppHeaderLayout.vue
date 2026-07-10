<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import Footer from '@/components/Footer.vue';
import type { BreadcrumbItemType } from '@/types';
import { ArrowUp } from 'lucide-vue-next';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const isVisible = ref(false);

const checkScroll = () => {
    isVisible.value = window.scrollY > 300;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

onMounted(() => {
    window.addEventListener('scroll', checkScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkScroll);
});
</script>

<template>
    <AppShell class="relative min-h-screen flex-col bg-gradient-to-br from-white to-indigo-100/20">
        <AppHeader :breadcrumbs="breadcrumbs" />
        <AppContent class="overflow-x-clip">
            <slot />
        </AppContent>
        <Footer />
        
        <!-- Premium Dynamic Scroll-to-Top Button -->
        <button 
            @click="scrollToTop" 
            class="fixed right-6 bottom-6 z-50 p-3 rounded-full bg-blue-600/90 text-white shadow-xl border border-blue-400/30 backdrop-blur-md hover:bg-blue-700 hover:scale-110 active:scale-95 transition-all duration-300"
            :class="isVisible ? 'opacity-100 translate-y-0 pointer-events-auto' : 'opacity-0 translate-y-4 pointer-events-none'"
            aria-label="Scroll to top"
        >
            <ArrowUp class="size-6 stroke-[2.5]" />
        </button>
    </AppShell>
</template>
