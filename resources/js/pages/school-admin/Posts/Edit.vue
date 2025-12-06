<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem, Post } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Receive post from controller
const props = defineProps<{ post: Post }>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Posts', href: '/school-admin/posts' },
  { title: 'Edit', href: `/school-admin/posts/${props.post.id}/edit` },
];

// IMPORTANT → preload values
const form = useForm({
  title: props.post.title,
  content: props.post.content || '',
  image: null, // new banner file
  images: props.post.images ? [...props.post.images] : [null], // keep existing order
});

// Add new input slot at bottom
const addNewInput = () => {
  form.images.push(null);
};

// Replace file at index
const handleFileChange = (e: any, index: number) => {
  form.images[index] = e.target.files[0];
};

const removeImage = (index: number) => {
  form.images.splice(index, 1);
};

function loadImg(img: any) {
  if (!img) return null;
  if (typeof img === 'string') return `/storage/uploads/${img}`; // existing
  return URL.createObjectURL(img); // new uploaded preview
}

// Submit
const submit = () => {
  form.post(`/school-admin/posts/${props.post.id}/update`)
}
</script>

<template>

  <Head title="Edit Post" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="rounded bg-white p-8 shadow">
      <h1 class="mb-4 text-2xl font-bold">Edit Post</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Title -->
        <div>
          <label class="block font-medium">Title</label>
          <Input v-model="form.title" type="text" class="w-full rounded border px-3 py-2" />
          <div v-if="form.errors.title" class="text-sm text-red-500">{{ form.errors.title }}</div>
        </div>

        <!-- Dynamic Image Inputs -->
        <div>
          <label class="mb-2 block font-medium">Gallery Images <small>1st image is banner</small></label>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 border p-3">
            <div class="rounded-md overflow-hidden border">
              <!-- Image Preview -->
              <div class="h-[300px] w-full border-b" v-if="props.post.image">
                <img :src="form.image ? loadImg(form.image) : loadImg(props.post.image)" class="h-full w-full rounded-t-md border-t object-cover" />
                <!-- <template v-else>
                  <div
                    class="flex h-full w-full items-center justify-center rounded-t-md border-t border-x bg-white text-xs text-gray-400">
                    No Image
                  </div>
                </template> -->
              </div>
              <!-- <div>{{ form.images[index] }}</div> -->
              <!-- File Input -->
              <div class="flex" v-if="props.post.image">
                <div class="flex items-center justify-center w-full">
                  <label
                    class="flex flex-col items-center justify-center h-[40px] w-full border-2 border-gray-300 border-dashed py-2 cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center">
                      <p class="text-xs text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                          Update Banner</span></p>
                    </div>
                    <Input type="file" accept="image/*" @Input="form.image = $event.target.files[0]" class="hidden" />
                  </label>
                </div>
                  <!-- Remove Button -->
                <button v-if="form.image" type="button" class="text-xs font-medium bg-red-500 hover:bg-red-600 text-neutral-100 p-2 px-5" @click="()=>{form.image = null}">
                  Reset
                </button>
              </div>
            </div>

            <!-- Dynamic Gallery images -->
            <div v-for="(image, index) in form.images" :key="index" class="rounded-md overflow-hidden border">
              <!-- Image Preview -->
              <div class="h-[300px] w-full border-b" v-if="image">
                <img :src="loadImg(image)" class="h-full w-full rounded-t-md border-t object-cover" />
                <!-- <template v-else>
                  <div
                    class="flex h-full w-full items-center justify-center rounded-t-md border-t border-x bg-white text-xs text-gray-400">
                    No Image
                  </div>
                </template> -->
              </div>
              <!-- <div>{{ form.images[index] }}</div> -->
              <!-- File Input -->
              <div class="flex" v-if="image">
                <div class="flex items-center justify-center w-full">
                  <label
                    class="flex flex-col items-center justify-center h-[40px] w-full border-2 border-gray-300 border-dashed py-2 cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center">
                      <p class="text-xs text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                          Update Image</span></p>
                    </div>
                    <input type="file" accept="image/*" :v-model="form.images[index]"
                      @change="(e) => handleFileChange(e, index)" class="hidden" />
                  </label>
                </div>
                <!-- Remove Button -->
                <button type="button" class="text-xs font-medium bg-red-500 hover:bg-red-600 text-neutral-100 p-2"
                  @click="removeImage(index)">
                  Remove
                </button>
              </div>

              <div class="gird grid-cols-1 justify-center w-full h-[340px]" v-else>
                <label :class="[
                  'flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600',
                  index < 1 ? 'h-[300px]' : 'h-[300px]'
                ]">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                        upload</span> or
                      drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 1MB)</p>
                  </div>
                  <input type="file" accept="image/*" :v-model="form.images[index]"
                    @change="(e) => handleFileChange(e, index)" class="hidden" />
                </label>

                <!-- Remove Button -->
                <button type="button"
                  class="text-xs font-medium bg-red-500 hover:bg-red-600 text-neutral-100 p-2 w-full h-[40px]"
                  @click="removeImage(index)">
                  Remove
                </button>
              </div>

            </div>
          </div>

          <!-- Add More Button -->
          <button type="button"
            class="mt-3 flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-white transition hover:bg-blue-700"
            @click="addNewInput">
            + Add Another Image
          </button>
        </div>
        <!-- Error -->
        <div v-if="form.errors.images" class="mt-2 text-sm text-red-500">
          {{ form.errors.images }}
        </div>

        <!-- Content -->
        <div>
          <label class="block font-medium">Content</label>
          <Textarea v-model="form.content" rows="10" class="w-full border rounded px-3 py-2"></Textarea>
        </div>

        <!-- Submit -->
        <div class="flex gap-2">
          <Button type="submit" class="bg-blue-600 px-4 py-2 text-white" :disabled="form.processing">
            {{ form.processing ? 'Saving...' : 'Save Changes' }}
          </Button>
          <Link href="/school-admin/posts">
          <Button type="button" class="bg-gray-500 px-4 py-2 text-white">Cancel</Button>
          </Link>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
