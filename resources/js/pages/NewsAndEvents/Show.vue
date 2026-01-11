<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Post } from '@/types';
import defaultProfileIcon from '@/../../resources/images/defaults/profile.png';
import { ArrowLeftIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ImageGallery from '@/components/kisxo/ImageGallery.vue';
// import { computed } from 'vue';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
    post: Post
}
const props = defineProps<Props>() // Make props reactive and type-safe.

console.log(props.post);
// const handleImageError = (event: Event) => {
//     (event.target as HTMLImageElement).src = defaultProfileIcon;
// };
/**
 * Helper to determine the correct image source.
 * If the string starts with http/https, use it as is.
 * Otherwise, prepend the local storage path.
 */
 const getImageUrl = (imagePath: string) => {
  if (!imagePath) return defaultProfileIcon; // Fallback if image is missing
  
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
<template>
    <AppLayout>
        <!-- Action buttons -->
        <div class="flex space-x-2 p-8 lg:p-16">
            <Link :href="`/news-events`" class="me-auto">
            <Button class="bg-gray-100 hover:bg-gray-200 text-black">
                <ArrowLeftIcon />
                News & Events
            </Button>
            </Link>
        </div>
        <div class="rounded-xl max-w-7xl p-8 lg:p-0 mx-auto space-y-6">

            <h1 class="font-bold text-gray-800 dark:text-white">
                {{ props.post.title }}
            </h1>

            <div>
                <template v-if="props.post.image">
                    <img :src="`${getImageUrl(props.post.image)}`" alt="Profile Image"
                        class="w-full h-[250px] md:h-[600px] object-cover aspect-video" />
                </template>
            </div>

            <div v-if="props.post.created_at" class="text-sm text-gray-500 dark:text-gray-400">
                Created at:
                {{
                    new Date(props.post.created_at).toLocaleString('en-CA', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                    })
                }}
            </div>

            <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line pb-20">
                {{ props.post.content || 'No message provided.' }}
            </div>

            <ImageGallery :images="props.post.images" />

        </div>
    </AppLayout>
</template>