<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from 'lucide-vue-next';
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

const carouselConfig = {
    itemsToShow: 1,
    wrapAround: true,
    autoplay: 7000, // 7 seconds autoplay
    transition: 1200, // Luxurious transition speed
};

const slides = [
    {
        tag: 'Welcome to',
        title: 'ARPS Jorhat',
        desc: 'This is where we teach students skills they need to transform themselves, others, and our global communities.',
        imgIndex: 1
    },
    {
        tag: 'Academics & Excellence',
        title: 'Inspiring Minds',
        desc: 'Nurturing curiosity, critical thinking, and intellectual growth through comprehensive and state-of-the-art educational programs.',
        imgIndex: 2
    },
    {
        tag: 'Infrastructure & Labs',
        title: 'Modern Campus',
        desc: 'Equipped with state-of-the-art scientific laboratories, a smart computer center, and spacious classrooms for interactive learning.',
        imgIndex: 3
    },
    {
        tag: 'Co-curricular Activities',
        title: 'Holistic Growth',
        desc: 'Fostering teamwork, discipline, and leadership through NCC training, sports, cultural events, and patriotic values.',
        imgIndex: 4
    }
];

// Map actual existing resolutions to prevent 404s and optimize page performance
const heroSrcsets: Record<number, string> = {
    1: '/storage/uploads/hero-1-720.webp 720w, /storage/uploads/hero-1.webp 1600w',
    2: '/storage/uploads/hero-2-720.webp 720w, /storage/uploads/hero-2.webp 1600w',
    3: '/storage/uploads/hero-3-720.webp 720w, /storage/uploads/hero-3-1600.webp 1600w, /storage/uploads/hero-3.webp 1920w',
    4: '/storage/uploads/hero-4-1600.webp 1600w, /storage/uploads/hero-4.webp 1920w',
};
</script>

<template>
    <div class="relative h-[70vh] w-full overflow-hidden bg-blue-950">
        <Carousel v-bind="carouselConfig" class="h-full w-full">
            <Slide v-for="(slide, index) in slides" :key="index">
                <div class="relative h-[70vh] w-full flex items-center justify-start overflow-hidden">
                    <!-- Image -->
                    <img
                        :src="`/storage/uploads/hero-${slide.imgIndex}.webp`"
                        :srcset="heroSrcsets[slide.imgIndex]"
                        sizes="100vw"
                        alt="Hero Slide"
                        class="absolute inset-0 h-full w-full object-cover object-center z-0"
                    />

                    <!-- Left-aligned Cinematic Overlay Content -->
                    <div class="absolute inset-0 z-10 flex items-center justify-start p-8 md:p-16 lg:p-24 bg-gradient-to-r from-blue-950/95 via-blue-950/65 to-transparent backdrop-blur-[1px]">
                        <div class="perspective-container z-10 max-w-xl text-left text-white">
                            <span class="reveal-3d-tag text-blue-300 text-xs font-bold uppercase tracking-widest bg-blue-500/15 px-3.5 py-1.5 rounded-full border border-blue-500/30 mb-4 inline-block drop-shadow-[0_2px_4px_rgba(0,0,0,0.4)]">
                                {{ slide.tag }}
                            </span>
                            
                            <h1 class="reveal-3d-title mb-4 text-4xl md:text-6xl font-black tracking-tight leading-tight drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                                <span class="text-[#ffeb00] drop-shadow-[0_2px_8px_rgba(255,235,0,0.3)]">
                                    {{ slide.title.split(' ')[0] }}
                                </span> 
                                {{ slide.title.split(' ').slice(1).join(' ') }}
                            </h1>
                            
                            <p class="reveal-3d-desc text-white text-sm md:text-lg leading-relaxed mb-8 font-bold drop-shadow-[0_2px_8px_rgba(0,0,0,0.6)]">
                                {{ slide.desc }}
                            </p>
                            
                            <div class="reveal-3d-btn flex flex-wrap gap-4">
                                <Link :href="`online-registration`" class="bg-gradient-to-r from-[#ff5544] to-[#ff7755] hover:scale-105 shadow-[0_10px_20px_rgba(255,85,68,0.3)] hover:shadow-[0_15px_25px_rgba(255,85,68,0.4)] text-white font-bold rounded-xl py-3 px-6 flex items-center transition duration-300 ease-in-out">
                                    <span>Admission Now</span>
                                    <ArrowUpRight class="inline ml-2 stroke-[2.5] w-4 h-4 text-current" />
                                </Link>

                                <Link :href="`hs-registration`" class="bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:scale-105 shadow-lg text-white font-bold rounded-xl py-3 px-6 flex items-center transition duration-300 ease-in-out">
                                    <span>HS Registration</span>
                                    <ArrowUpRight class="inline ml-2 stroke-[2.5] w-4 h-4 text-current" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </Slide>
        </Carousel>
    </div>
</template>

<style scoped>
.perspective-container {
    perspective: 1000px;
}

@keyframes reveal3DText {
    0% {
        opacity: 0;
        transform: translateY(30px) rotateX(-45deg) scale(0.95);
        transform-origin: top center;
    }
    100% {
        opacity: 1;
        transform: translateY(0) rotateX(0deg) scale(1);
        transform-origin: top center;
    }
}

.reveal-3d-tag,
.reveal-3d-title,
.reveal-3d-desc,
.reveal-3d-btn {
    opacity: 0;
}

:deep(.carousel__slide--active) .reveal-3d-tag {
    animation: reveal3DText 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    animation-delay: 0.1s;
}

:deep(.carousel__slide--active) .reveal-3d-title {
    animation: reveal3DText 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    animation-delay: 0.25s;
}

:deep(.carousel__slide--active) .reveal-3d-desc {
    animation: reveal3DText 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    animation-delay: 0.4s;
}

:deep(.carousel__slide--active) .reveal-3d-btn {
    animation: reveal3DText 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    animation-delay: 0.55s;
}
</style>
