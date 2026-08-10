<script setup lang="ts">
import defaultProfileIcon from '@/../../resources/images/defaults/profile.png';
import { Profile } from '@/types';
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
    <div class="px-8 py-20 bg-gradient-to-b from-slate-50 to-blue-50/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-400/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-400/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-12" data-aos="fade-up">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-widest bg-blue-100 px-3 py-1 rounded-full border border-blue-200 mb-3 inline-block">School Leadership</span>
                <h2 class="text-4xl font-extrabold tracking-tight text-slate-900">Leadership Messages</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 py-4">
                <Link v-for="(profile, index) in props.profiles" :href="`/profiles/${profile.id}`" :key="profile.id"
                    data-aos="fade-up" data-aos-duration="600" :data-aos-delay="150 * index"
                    class="group w-full max-w-[360px] mx-auto block rounded-3xl overflow-hidden bg-white border border-slate-100 shadow-[0_15px_30px_rgba(0,0,0,0.03)] hover:shadow-[0_35px_60px_rgba(59,130,246,0.12)] hover:-translate-y-2 transition-all duration-500 h-full flex flex-col justify-between">
                
                    <div class="aspect-[1.05/1] overflow-hidden relative bg-slate-100">
                        <img v-if="profile.image" :src="`${profile.image}`"
                            class="w-full h-full object-cover transition-transform duration-750 group-hover:scale-105" @error="handleImageError" alt="Profile Image" />
                        <img v-else :src="defaultProfileIcon" class="w-full h-full object-cover opacity-80" alt="Profile Image">
                        
                        <span class="absolute top-4 left-4 z-10 bg-blue-600/80 backdrop-blur-md border border-white/15 text-white text-xs font-extrabold uppercase tracking-wider px-3.5 py-1.5 rounded-full shadow-md">
                            {{ profile.role?.display_name || "Leader" }}
                        </span>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 pb-2 group-hover:text-blue-600 transition-colors duration-300">
                                {{ profile.name || "Leader Name" }}
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                                {{ profile?.message ? profile.message.slice(0, 160) + "..." : "No message provided." }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 text-blue-600 font-bold text-xs uppercase tracking-wider group-hover:text-blue-700 transition-colors duration-300">
                            <span>Read Message</span>
                            <BookOpenCheck class="size-4 transition-transform duration-300 group-hover:translate-x-1" />
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
