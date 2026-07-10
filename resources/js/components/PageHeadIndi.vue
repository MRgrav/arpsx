<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Props {
    heading: string;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="relative w-full bg-gradient-to-r from-sky-50 via-blue-50/40 to-indigo-50 py-8 px-6 overflow-hidden shadow-sm border-b border-blue-100">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-blue-300/10 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-300/10 rounded-full blur-[80px] pointer-events-none"></div>

        <!-- Elegant Tricolor Indian Flag Strip along the top edge -->
        <div class="absolute top-0 left-0 w-full h-[4px] flex z-20">
            <span class="flex-1 bg-[#ff9933]"></span>
            <span class="w-8 bg-white flex justify-center items-center relative shadow-sm">
                <!-- Mini navy blue dot representing the Ashoka Chakra -->
                <span class="w-1.5 h-1.5 rounded-full bg-[#000080]"></span>
            </span>
            <span class="flex-1 bg-[#138808]"></span>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 flex flex-col items-center text-center">
            <!-- Subtitle Pill -->
            <span class="text-blue-600 text-xs font-bold uppercase tracking-widest bg-blue-600/10 px-3.5 py-1.5 rounded-full border border-blue-400/20 mb-2 inline-block shadow-xs">
                ARPS Jorhat
            </span>

            <!-- Main Heading with premium styling -->
            <h1 class="text-2xl md:text-3xl font-extrabold text-blue-900 tracking-tight">
                {{ props.heading }}
            </h1>

            <!-- Simple automatic breadcrumb layout -->
            <nav class="mt-2 flex items-center justify-center gap-2 text-xs font-semibold text-blue-600/70">
                <Link href="/" class="hover:text-blue-900 transition-colors duration-200">Home</Link>
                <span class="opacity-40">/</span>
                <span class="text-blue-900 font-bold">{{ props.heading }}</span>
            </nav>
        </div>
    </div>
</template>
