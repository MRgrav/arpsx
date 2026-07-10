<script setup lang="ts">
import cultureImage_720 from '@/../../resources/images/culture-720.avif';
import cultureImage from '@/../../resources/images/culture.avif';
import nccImage_1200 from '@/../../resources/images/ncc-1200.avif';
import nccImage from '@/../../resources/images/ncc.avif';
import sportImage from '@/../../resources/images/sport.avif';
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div class="bg-gradient-to-b from-[#3d5cd8] to-[#253ca6] p-8 py-24 relative overflow-hidden border-b border-white/5">
        <!-- Subtle Ambient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-white/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-400/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto text-white relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-blue-200 text-xs font-bold uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full border border-white/20 mb-3 inline-block">Co-Curricular</span>
                <h2 class="text-4xl font-extrabold tracking-tight text-white">Our Activities</h2>
            </div>

            <!-- NCC Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center py-8">
                <div class="flex flex-col justify-center" data-aos="fade-right" data-aos-duration="500">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-1.5 h-8 bg-blue-300 rounded-full"></span>
                        <h3 class="text-2xl font-bold tracking-tight text-white">NCC at a Glance</h3>
                    </div>
                    <p class="text-blue-100/90 leading-relaxed text-base font-medium">
                        Behind every successful student is a team of dedicated educators and professionals. Our teachers
                        inspire learning with passion and purpose, while our support staff ensures a safe, efficient, and
                        welcoming environment for all.
                    </p>
                </div>
                <Link :href="'/ncc'" class="group relative block rounded-3xl overflow-hidden shadow-2xl border border-white/10 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] transition duration-500 transform hover:-translate-y-1 h-80" data-aos="fade-left" data-aos-duration="500">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        :src="nccImage"
                        :srcset="`${nccImage_1200} 1200w, ${nccImage} 1920w`"
                        sizes="(max-width: 1024px) 100vw, 50vw"
                        alt="NCC activity">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/45 via-transparent to-transparent"></div>
                </Link>
            </div>

            <!-- Sports Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center py-8">
                <!-- Mobile text placement logic -->
                <div class="flex flex-col justify-center lg:hidden" data-aos="fade-left" data-aos-duration="500">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-1.5 h-8 bg-blue-300 rounded-full"></span>
                        <h3 class="text-2xl font-bold tracking-tight text-white">Sports at a Glance</h3>
                    </div>
                    <p class="text-blue-100/90 leading-relaxed text-base font-medium">
                        Sports are an integral part of our school’s curriculum, promoting physical fitness, teamwork,
                        and a healthy competitive spirit. Our students actively participate in various indoor and
                        outdoor games, excelling at inter-school, district, and state-level events.
                    </p>
                </div>
                
                <Link :href="'/sports'" class="group relative block rounded-3xl overflow-hidden shadow-2xl border border-white/10 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] transition duration-500 transform hover:-translate-y-1 h-80" data-aos="fade-right" data-aos-duration="500">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        :src="sportImage" 
                        alt="Sports activity">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/45 via-transparent to-transparent"></div>
                </Link>

                <div class="hidden lg:flex flex-col justify-center" data-aos="fade-left" data-aos-duration="500">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-1.5 h-8 bg-blue-300 rounded-full"></span>
                        <h3 class="text-2xl font-bold tracking-tight text-white">Sports at a Glance</h3>
                    </div>
                    <p class="text-blue-100/90 leading-relaxed text-base font-medium">
                        Sports are an integral part of our school’s curriculum, promoting physical fitness, teamwork,
                        and a healthy competitive spirit. Our students actively participate in various indoor and
                        outdoor games, excelling at inter-school, district, and state-level events.
                    </p>
                </div>
            </div>

            <!-- Cultural Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center py-8">
                <div class="flex flex-col justify-center" data-aos="fade-right" data-aos-duration="500">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-1.5 h-8 bg-blue-300 rounded-full"></span>
                        <h3 class="text-2xl font-bold tracking-tight text-white">Cultural Activities</h3>
                    </div>
                    <p class="text-blue-100/90 leading-relaxed text-base font-medium">
                        Our school celebrates creativity through vibrant cultural programs that include music, dance,
                        drama, and art. These activities foster confidence, teamwork, and a deep appreciation for
                        tradition. Every student is encouraged to explore and showcase their unique talents.
                    </p>
                </div>
                <Link :href="'creative-performing-arts'" class="group relative block rounded-3xl overflow-hidden shadow-2xl border border-white/10 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] transition duration-500 transform hover:-translate-y-1 h-80" data-aos="fade-left" data-aos-duration="500">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        :src="cultureImage"
                        :srcset="`${cultureImage_720} 720w, ${cultureImage} 1600w`"
                        sizes="(max-width: 1024px) 100vw, 50vw"
                        alt="Cultural activity">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/45 via-transparent to-transparent"></div>
                </Link>
            </div>
        </div>
    </div>
</template>
