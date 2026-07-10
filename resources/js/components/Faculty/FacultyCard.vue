<script setup lang="ts">
import { Profile } from '@/types';
import { Link } from '@inertiajs/vue3';
// import { BookOpenCheck } from 'lucide-vue-next';

const defaultProfileIcon = '/images/defaults/profile.png';

interface Props {
    profile: Profile;
}
const props = defineProps<Props>();

const handleImageError = (event: Event) => {
    (event.target as HTMLImageElement).src = defaultProfileIcon;
};

const getProfileImageUrl = () => {
    const img = props.profile.image;
    if (!img || img === 'null' || img === 'undefined' || img.trim() === '') {
        return defaultProfileIcon;
    }
    if (img.startsWith('http://') || img.startsWith('https://')) {
        return img;
    }
    return `/storage/uploads/${img}`;
};
</script>

<template>
    <!--<Link :href="`/profiles/${props.profile.id}`" class="block rounded-tl-4xl rounded-tr-lg rounded-br-4xl rounded-bl-lg hover:rounded-tl-lg hover:rounded-tr-4xl hover:rounded-br-lg hover:rounded-bl-4xl duration-200 ease-in-out overflow-hidden relative">
        <div class="aspect-[1/1] overflow-hidden">
            <img :src="getProfileImageUrl()"
                class="w-full h-full object-cover" @error="handleImageError" alt="Profile Image" />
        </div>
        <!-- HOD Badge Overlay
        <div v-if="props.profile.is_hod" class="-mt-8 min-w-[100px] w-fit ms-2 bg-zinc-950/30 backdrop-blur-sm text-white text-sm uppercase font-bold tracking-wider px-2 py-0.5 rounded shadow-sm z-10 ">
            HOD
        </div>
        <div class="p-4 bg-[#ff7c7c] text-white text-center h-full">
            <h4>
                {{ props.profile.name || "Please enter name" }}
            </h4>
            <p class="opacity-70 font-semibold">
                {{ props.profile.detail || "Please enter a details" }}
            </p>
        </div>
        <div class="w-full h-full opacity-0 hover:opacity-100 bg-blue-900/20 absolute top-0 left-0 duration-300 ease-in-out flex justify-center items-end">
            <!-- <span class="text-white font-bold flex gap-2 text-xl"> <UserSearch class="size-10"/></span>
        </div>
    </Link> -->

    <Link :href="`/profiles/${props.profile.id}`" class="group relative block duration-200 ease-in-out">
        <div class="grid h-full grid-cols-5 border border-zinc-300 p-1">
            <div class="col-span-2 aspect-[1/1]">
                <img
                    :src="getProfileImageUrl()"
                    class="aspect-square h-full w-auto rounded-lg object-cover p-1 shadow-blue-700/20 saturate-50 duration-200 ease-in-out group-hover:z-[999] group-hover:-translate-y-5 group-hover:scale-102 group-hover:-rotate-3 group-hover:shadow-xl group-hover:saturate-100"
                    @error="handleImageError"
                    alt="Profile Image"
                />
            </div>
            <div class="col-span-3 flex h-full flex-col justify-end p-4 py-2 text-blue-950">
                <!-- bg-[#ff7c7c] -->
                <div
                    v-if="props.profile.is_hod"
                    class="mb-2 w-fit min-w-[100px] border-b border-red-500 py-0.5 text-sm font-bold tracking-widest text-orange-600 uppercase backdrop-blur-sm"
                >
                    HOD
                </div>
                <h3 class="mb-1 border-b border-dotted border-orange-500/40 text-lg uppercase">
                    {{ props.profile.name || 'Please enter name' }}
                </h3>
                <p class="font-serif text-xs font-semibold opacity-70">
                    {{ props.profile.detail || 'Info not available' }}
                </p>
            </div>
        </div>

        <!-- HOD Badge Overlay -->
        <!-- <div
            v-if="props.profile.is_hod"
            class="z-10 ms-2 -mt-8 w-fit min-w-[100px] rounded bg-zinc-950/30 px-2 py-0.5 text-sm font-bold tracking-wider text-white uppercase shadow-sm backdrop-blur-sm"
        >
            HOD
        </div> -->

        <div
            class="absolute top-0 left-0 flex h-full w-full items-end justify-center bg-gradient-to-r from-transparent to-sky-500/20 opacity-0 duration-300 ease-in-out hover:opacity-100"
        >
            <!-- <span class="text-white font-bold flex gap-2 text-xl"> <UserSearch class="size-10"/></span> -->
        </div>
    </Link>
</template>
