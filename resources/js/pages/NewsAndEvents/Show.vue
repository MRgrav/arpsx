<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Post } from '@/types';
import defaultProfileIcon from '@/../../resources/images/defaults/profile.png';
import { ArrowLeftIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import ImageGallery from '@/components/kisxo/ImageGallery.vue';
import { computed } from 'vue';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
    post: Post
}
const props = defineProps<Props>() // Make props reactive and type-safe.

console.log(props.post);
const handleImageError = (event: Event) => {
    (event.target as HTMLImageElement).src = defaultProfileIcon;
};
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
                    <img :src="`/storage/uploads/${props.post.image}`" alt="Profile Image"
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