<script setup lang="ts">
import { Profile } from '@/types';
import defaultProfileIcon from '@/../../resources/images/defaults/profile.png';
import { Link } from '@inertiajs/vue3';
import { BookOpenCheck } from 'lucide-vue-next';

interface Props {
    profiles: Profile[];
}
const props = defineProps<Props>();

const handleImageError = (event: Event) => {
    (event.target as HTMLImageElement).src = defaultProfileIcon;
};
</script>


<template>
    <div class="px-8 py-16 bg-neutral-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-center py-10 text-[#4e71ff]" data-aos="fade-in">Leadership Messages</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 py-10">
                <Link v-for="(profile, key, index) in props.profiles" :href="`/profiles/${profile.id}`" :key="profile.id"
                    data-aos="fade-up" data-aos-duration="400" data-aos-easing="ease-in-out" :data-aos-delay="200 * index"
                    class="bg-[var(--primary-brand-500)]/80 w-full max-w-[400px] mx-auto rounded-xs block shadow-md h-full">
                <div
                    class="-translate-1 hover:-translate-1.5 bg-white w-full h-full border-[var(--primary-brand-500)]/80 border transition duration-400 ease-in-out">
                    <div class="aspect-[1/1] object-center object-cover relative">
                        <img v-if="profile.image" :src="`/storage/uploads/${profile.image}`"
                            class="w-full h-full object-cover overflow-hidden" @error="handleImageError" alt="Profile Image" />
                        <img v-else :src="defaultProfileIcon" alt="">
                        <h3 class="px-4 py-2 absolute text-white text-sm bg-[#4e71ff] top-0 left-0">
                            {{ profile.role?.display_name || "name" }}
                        </h3>
                    </div>
                    <div class="p-4 border-t border-[var(--primary-brand-500)]">
                        <h3 class="text-zinc-600 pb-2 text-2xl">
                            {{ profile.name || "Please Select a Role" }}
                        </h3>
                        <p class="text-slate-500 max-t text-sm min-h-20">
                            {{ profile?.message ? profile.message.slice(0, 220) + "..." : "No Message" }}
                        </p>
                    </div>
                    <div
                        class="px-4 mt-auto pb-4 justify-center flex items-center gap-2 text-gray-400 hover:text-gray-800">
                        <small>Read More </small>
                        <BookOpenCheck class="size-4" />
                    </div>
                </div>
                </Link>
            </div>
        </div>
    </div>
</template>
