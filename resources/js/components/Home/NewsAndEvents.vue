<script setup lang="ts">
import { Post } from '@/types';
import { Link } from '@inertiajs/vue3';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
    posts: Post[];
}
const props = defineProps<Props>(); // Make props reactive and type-safe.

/**
 * Helper to determine the correct image source.
 * If the string starts with http/https, use it as is.
 * Otherwise, prepend the local storage path.
 */
const getImageUrl = (imagePath: string) => {
    if (!imagePath) return '/images/placeholder.jpg'; // Fallback if image is missing

    try {
        // Check if it's a full URL (Appwrite)
        new URL(imagePath);
        // const imageUrl = imagePath.replace('/view', '/preview&width=600&quality=70');
        return imagePath;
    } catch (e: any) {
        console.error(e);
        // It's a filename (Old Local Storage)
        return `/storage/uploads/${imagePath}`;
    }
};
</script>

<template>
  <div class="bg-gradient-to-br from-[#3d5cd8] via-[#2f4cb5] to-[#1e3494] px-8 py-20 relative overflow-hidden">
    <!-- Ambient Light Leaks -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-white/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-400/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
      <div class="text-center mb-12" data-aos="fade-up">
        <span class="text-blue-200 text-xs font-bold uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full border border-white/20 mb-3 inline-block">School Updates</span>
        <h2 class="text-4xl font-extrabold tracking-tight text-white">News & Events</h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 py-4 mb-12">
        <Link :href="`/news-events/${post.id}`" v-for="(post, index) in props.posts" :key="post.id"
          class="group h-80 rounded-3xl overflow-hidden border border-white/15 shadow-xl hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] transition-all duration-500 transform hover:-translate-y-2 relative bg-blue-950 block"
          data-aos="fade-up" data-aos-duration="600" :data-aos-delay="100 * index">
          
          <!-- Image Layer -->
          <img 
            :src="getImageUrl(post.image)" 
            class="absolute inset-0 h-full w-full object-cover transition-transform duration-750 group-hover:scale-110" 
            alt="" 
          />
          
          <!-- Glassmorphic Gradient Overlay -->
          <div class="absolute inset-0 bg-gradient-to-t from-blue-950/95 via-blue-950/45 to-transparent flex flex-col justify-end p-6">
            <div class="text-[#ffeb00] text-xs font-extrabold uppercase tracking-wider mb-2 flex items-center gap-1.5 drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
              <span class="w-1.5 h-1.5 bg-[#ffeb00] rounded-full"></span>
              <span v-if="post.created_at">
                {{
                  new Date(post.created_at).toLocaleString('en-CA', {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                  })
                }}
              </span>
            </div>
            <h3 class="text-xl font-bold text-white mb-3 leading-tight group-hover:text-[#ffeb00] transition-colors duration-300">{{ post.title }}</h3>
            <div class="text-white/80 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transform translate-y-3 group-hover:translate-y-0 transition-all duration-300">
              <span>Read Article</span>
              <span class="inline-block transition-transform duration-300 group-hover:translate-x-1.5">→</span>
            </div>
          </div>
        </Link>
      </div>
      
      <div class="flex justify-center" data-aos="zoom-in">
        <Link :href="'/news-events'" class="bg-white hover:bg-slate-100 text-blue-700 font-extrabold px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 text-sm">
          View All Updates
        </Link>
      </div>
    </div>
  </div>
</template>
