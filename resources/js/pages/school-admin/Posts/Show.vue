<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem, Post } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import defaultProfileIcon from '@/../../resources/images/defaults/profile.png';
import ImageGallery from '@/components/kisxo/ImageGallery.vue';

const props = defineProps<{ post: Post }>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'Posts',
    href: '/school-admin/posts',
  },
  {
    title: 'View Post',
    href: `/school-admin/posts/${props.post.id}`,
  },
];

const handleImageError = (event: Event) => {
  (event.target as HTMLImageElement).src = defaultProfileIcon;
};

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
  <Head :title="`Notification - ${props.post.title}`" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class=" bg-white dark:bg-gray-900 rounded-xl p-6  space-y-6">
      <div class="flex items-center justify-between">
        <Link href="/school-admin/posts">
          <Button variant="secondary">← Back to Posts</Button>
        </Link>
        <Link :href="`/school-admin/posts/${props.post.id}/edit`">
          <Button>Edit</Button>
        </Link>
      </div>
      <div>
        <img :src="`${getImageUrl(props.post.image)}`" alt="Profile Image" class="max-h-[400px]" @error="handleImageError($event)" />
      </div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
          {{ props.post.title }}
      </h1>

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

      <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
        {{ props.post.content || 'No message provided.'}}
      </div>

      <ImageGallery :images="props.post.images" />

    </div>
  </SchoolAdminLayout>
</template>
