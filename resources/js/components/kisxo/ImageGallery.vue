<template>
  <div class="pb-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div
        v-for="(img, index) in props.images"
        :key="index"
        class="relative group rounded overflow-hidden border bg-gray-100 cursor-pointer"
        @click="openLightbox(index)"
      >
        <img
          :src="typeof img === 'string' ? `${getImageUrl(img)}` : URL.createObjectURL(img)"
          class="w-full h-[250px] object-cover transition duration-200 group-hover:scale-105"
        />
      </div>
    </div>

    <!-- NEW LIGHTBOX (ONLY ADDED) -->
    <div
      v-if="lightbox.open"
      class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
      @click.self="closeLightbox"
    >
      <img
        :src="getLightboxImageUrl(lightbox.index)"
        class="max-w-[90vw] max-h-[90vh] object-contain rounded shadow-lg"
      />

      <!-- Close -->
      <button
        class="absolute top-4 right-4 text-white text-3xl font-bold"
        @click="closeLightbox"
      >×</button>

      <!-- Prev -->
      <button
        v-if="lightbox.index > 0"
        class="absolute left-4 text-white text-4xl"
        @click.stop="lightbox.index--"
      >‹</button>

      <!-- Next -->
      <button
        v-if="lightbox.index < props.images.length - 1"
        class="absolute right-4 text-white text-4xl"
        @click.stop="lightbox.index++"
      >›</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';

interface Props {
  images: (string | File)[]
}
const props = defineProps<Props>()

const lightbox = reactive({
  open: false,
  index: 0,
})

const openLightbox = (i: number) => {
  lightbox.open = true
  lightbox.index = i
}

const closeLightbox = () => {
  lightbox.open = false
}

const getLightboxImageUrl = (index: number): string => {
  const img = props.images[index];
  if (!img) return '/images/placeholder.jpg';
  
  return typeof img === 'string' 
    ? getImageUrl(img) 
    : URL.createObjectURL(img);
};


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
}
</script>
