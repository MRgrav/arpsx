<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import facultyImage from '@/../../resources/images/faculty.avif';
import facultyImage_720 from '@/../../resources/images/faculty-720.avif';
import studentsImage from '@/../../resources/images/students.avif';
import staffsImage from '@/../../resources/images/staffs.avif';


const data = [
    {
        link: "/faculty",
        title: "Our Faculties",
        image: facultyImage,
        srcset: `${facultyImage_720} 720w, ${facultyImage} 1600w`
    },
    {
        link: "/",
        title: "Our Students",
        image: studentsImage,
        srcset: ''
    },
    {
        link: "/",
        title: "Our Staffs",
        image: staffsImage,
        srcset: ''
    },
]

</script>
<template>
    <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-950 p-8 py-24 relative overflow-hidden border-b border-white/5">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-400/20 rounded-full blur-[140px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-200 text-xs font-bold uppercase tracking-widest bg-white/10 px-3.5 py-1.5 rounded-full border border-white/20 mb-3 inline-flex items-center gap-2 drop-shadow-sm">
                    <span class="flex w-3.5 h-2 rounded-[1px] overflow-hidden">
                        <span class="w-1/3 bg-[#ff9933]"></span>
                        <span class="w-1/3 bg-white"></span>
                        <span class="w-1/3 bg-[#138808]"></span>
                    </span>
                    Directory
                </span>
                <h2 class="text-4xl font-extrabold tracking-tight text-white drop-shadow-md">Who We Are</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 py-4">
                <Link :href="row.link" v-for="row in data" :key="row.title" class="group block relative rounded-3xl overflow-hidden bg-white/10 backdrop-blur-lg border border-white/20 hover:border-white/30 shadow-2xl hover:shadow-[0_30px_60px_rgba(0,0,0,0.3)] transition-all duration-500 transform hover:-translate-y-2 h-80">
                    <!-- Elegant Indian Flag Tri-color Accent Strip at top of each card -->
                    <div class="absolute top-0 left-0 w-full h-[4px] flex z-20">
                        <span class="flex-1 bg-[#ff9933]"></span>
                        <span class="w-6 bg-white flex justify-center items-center relative">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#000080]"></span>
                        </span>
                        <span class="flex-1 bg-[#138808]"></span>
                    </div>

                    <!-- Image -->
                    <img 
                        :src="row.image" 
                        :srcset="row.srcset || undefined"
                        sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                        alt="" 
                        class="h-full w-full object-cover transition-transform duration-750 group-hover:scale-105"
                    >
                    <!-- Glassmorphic Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-950/40 to-transparent flex flex-col justify-end p-6">
                        <span class="text-[#ffeb00] text-xs font-extrabold uppercase tracking-wider mb-1 drop-shadow-[0_1px_3px_rgba(0,0,0,0.5)]">ARPS Jorhat</span>
                        <h3 class="text-2xl font-bold text-white mb-2 transition-colors duration-200 group-hover:text-[#ffeb00] drop-shadow-[0_2px_4px_rgba(0,0,0,0.4)]">{{row.title}}</h3>
                        <div class="text-white/80 text-sm font-semibold flex items-center gap-1.5 transform translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <span>Learn More</span>
                            <span class="inline-block transition-transform duration-300 group-hover:translate-x-1.5">→</span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>