<script setup lang="ts">
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'
import { ArrowUpRight } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const carouselConfig = {
  itemsToShow: 1,
  wrapAround: true,
  autoplay: 3000,
}

// Map actual existing resolutions to prevent 404s and optimize page performance
const heroSrcsets: Record<number, string> = {
  1: '/storage/uploads/hero-1-720.jpeg 720w, /storage/uploads/hero-1.jpeg 1600w',
  2: '/storage/uploads/hero-2-720.jpeg 720w, /storage/uploads/hero-2.jpeg 1600w',
  3: '/storage/uploads/hero-3-720.jpeg 720w, /storage/uploads/hero-3-1600.jpeg 1600w, /storage/uploads/hero-3.jpeg 1920w',
  4: '/storage/uploads/hero-4-720.jpeg 720w, /storage/uploads/hero-4-1600.jpeg 1600w, /storage/uploads/hero-4.jpeg 1920w',
}
</script>

<template>
  <div class="relative w-full h-[70vh] overflow-hidden">
    <Carousel v-bind="carouselConfig" class="w-full h-full">
      <Slide v-for="index in 4" :key="index">
        <div class="w-full h-[70vh]">
          <img
            :src="`/storage/uploads/hero-${index}.jpeg`"
            :srcset="heroSrcsets[index]"
            sizes="100vw"
            alt="Hero Slide"
            class="w-full h-full object-cover object-center"
          />
        </div>
      </Slide>
    </Carousel>


    <!-- ✅ Centered Overlay Content -->
    <div class="absolute inset-0 flex justify-center items-end p-8 lg:pb-16">
      <div class="z-10 bg-blue-600/50 p-6 text-white" data-aos="fade-right">
        <span>Welcome to</span>
        <h1><span class="text-[#ffeb00]">ARPS</span> Jorhat</h1>
        <span>This is where we teach students skills they need to transform themselves, others, and our global communities.</span>
        <div class="flex justify-center mt-5" data-aos="fade-right">
            <Link  :href="`online-registration`" class="bg-[#ff5544] hover:bg-[#ff6655] hover:scale-102 rounded-xs py-2 px-4 flex items-center ease-in-out duration-300">
                <span>Admission Now</span>
                <ArrowUpRight class="inline ml-1 stroke-[2.5] w-4 h-4 text-current" />
            </Link>

            <Link  :href="`hs-registration`" class="bg-[#ff5334]/80 backdrop-blur-sm ml-4 hover:bg-[#ff6655] hover:scale-102 rounded-xs py-2 px-4 flex items-center ease-in-out duration-300">
                <span>HS Registration</span>
                <ArrowUpRight class="inline ml-1 stroke-[2.5] w-4 h-4 text-current" />
            </Link>
        </div>
      </div>
    </div>
  </div>
</template>
