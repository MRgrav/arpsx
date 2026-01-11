<script setup lang="ts">
import { Post } from '@/types';
import { Link } from '@inertiajs/vue3';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
  posts: Post[]
}
const props = defineProps<Props>() // Make props reactive and type-safe.

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
    const imageUrl = imagePath.replace('/view', '/preview&width=600&quality=70');
    return imageUrl;
  } catch (e: any) {
    console.error(e);
    // It's a filename (Old Local Storage)
    return `/storage/uploads/${imagePath}`;
  }
}
</script>

<template>
  <div class="bg-[#4e71ff] px-8">
    <div class="py-16 max-w-7xl mx-auto">
      <h2 class="text-center text-white py-10 font-semibold" data-aos="fade-in">News & Events</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 py-10">
        <Link :href="`/news-events/${post.id}`" v-for="(post, index) in props.posts" :key="post.id"
          class="h-64 border border-blue-200 bg-cover bg-center bg-no-repeat border-r-4 border-b-4 transform transition duration-300 hover:scale-101 relative"
          data-aos="fade-up" data-aos-duration="400" data-aos-easing="ease-in-out" :data-aos-delay="100 * index"
          :style="{ backgroundImage: `url('${getImageUrl(post.image)}')` }">
        <div
          class=" bg-[#022CB84F] hover:bg-[#012DB8B5] flex flex-col justify-end transition-colors duration-300 h-full">
          <div
            class="text-center text-white text-sm opacity-0 hover:opacity-100 absolute top-0 w-full h-full grid place-content-center -translate-x-4 hover:translate-x-4 duration-300">
            Read More →</div>
          <div class="text-[#F5FA70CF] p-5">
            <h3 class="text-lg font-semibold">{{ post.title }}</h3>
            <span v-if="post.created_at" class="font-bold text-sm">
              {{
                new Date(post.created_at).toLocaleString('en-CA', {
                  month: 'short',
                  day: '2-digit',
                  year: 'numeric',
                })
              }}
            </span>
          </div>
        </div>
        </Link>
      </div>
    </div>
  </div>
</template>