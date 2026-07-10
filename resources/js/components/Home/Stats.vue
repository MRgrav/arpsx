<script setup lang="ts">
import { UserPen, GraduationCapIcon } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import Vue3Autocounter from 'vue3-autocounter';

/**
 * Couner logic to only start counting when visible
 */
const teachersRef = ref();
const studentsRef = ref();
const alumniRef = ref();

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    teachersRef.value.start(); // start counting
                    studentsRef.value.start(); // start counting
                    alumniRef.value.start(); // start counting
                    observer.unobserve(entry.target); // run only once
                }
            });
        },
        { threshold: 0.3 }
    );

    if (teachersRef.value?.$el) {
        observer.observe(teachersRef.value.$el);
    }
    if (studentsRef.value?.$el) {
        observer.observe(studentsRef.value.$el);
    }
    if (alumniRef.value?.$el) {
        observer.observe(alumniRef.value.$el);
    }
});
</script>
<template>
    <div class="bg-gradient-to-br from-[#0b1329] via-[#101b35] to-[#070b18] text-white p-8 py-24 relative overflow-hidden border-b border-white/5">
        <!-- Dashboard ambient glow effects -->
        <div class="absolute top-1/4 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 translate-x-1/2 translate-y-1/2 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20 mb-3 inline-block">Our Impact</span>
                <h2 class="text-4xl font-extrabold tracking-tight text-white">Heart of Our Success</h2>
            </div>

            <!-- Stats Rows with modern layout -->
            <div class="space-y-16">
                <!-- Section 1: Teachers & Staff -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right" data-aos-duration="600" class="lg:pr-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-1 h-8 bg-indigo-500 rounded-full"></span>
                            <h3 class="text-2xl font-bold tracking-tight text-white">Teachers & Staffs</h3>
                        </div>
                        <p class="text-slate-350 text-base leading-relaxed">
                            Behind every successful student is a team of dedicated educators and professionals. Our teachers
                            inspire learning with passion and purpose, while our support staff ensures a safe, efficient,
                            and welcoming environment for all.
                        </p>
                    </div>
                    <div class="flex justify-center lg:justify-end" data-aos="fade-left" data-aos-duration="600">
                        <div class="w-full max-w-[400px] bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl shadow-xl hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-all duration-300"></div>
                            <div class="flex justify-center mb-4">
                                <svg class="size-16 text-purple-400 group-hover:scale-110 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path d="M192,120a59.91,59.91,0,0,1,48,24" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path d="M16,144a59.91,59.91,0,0,1,48-24" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <circle cx="128" cy="144" r="40" fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                    <path d="M72,216a65,65,0,0,1,112,0" fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                    <path d="M161,80a32,32,0,1,1,31,40" fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                    <path d="M64,120A32,32,0,1,1,95,80" fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                </svg>
                            </div>
                            <p class="text-center text-6xl font-black bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent select-none">
                                <Vue3Autocounter ref="teachersRef" :startAmount='0' :endAmount='71' :duration='1.5' suffix='+' />
                            </p>
                            <p class="text-center text-slate-400 text-xs font-semibold uppercase tracking-wider mt-2">Active Educators</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Students -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center lg:flex-row-reverse">
                    <!-- On desktop, place image/counter on left side -->
                    <div class="flex justify-center lg:justify-start order-2 lg:order-1" data-aos="fade-right" data-aos-duration="600">
                        <div class="w-full max-w-[400px] bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl shadow-xl hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all duration-300"></div>
                            <div class="flex justify-center mb-4">
                                <UserPen class="size-16 text-blue-400 group-hover:scale-110 transition-transform duration-300" />
                            </div>
                            <p class="text-center text-6xl font-black bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent select-none">
                                <Vue3Autocounter ref="studentsRef" :startAmount='0' :endAmount='712' :duration='1.5' suffix='+' />
                            </p>
                            <p class="text-center text-slate-400 text-xs font-semibold uppercase tracking-wider mt-2">Enrolled Students</p>
                        </div>
                    </div>
                    <div data-aos="fade-left" data-aos-duration="600" class="lg:pl-8 order-1 lg:order-2">
                        <div class="flex items-center gap-3 mb-4 justify-start lg:justify-end">
                            <span class="w-1 h-8 bg-blue-500 rounded-full"></span>
                            <h3 class="text-2xl font-bold tracking-tight text-white">Students</h3>
                        </div>
                        <p class="text-slate-350 text-base leading-relaxed text-left lg:text-right">
                            Curious minds, bright ideas, and boundless energy — our students bring life to the campus every
                            day. With opportunities to lead, create, and grow, they embody the spirit of learning in every
                            corner of the school.
                        </p>
                    </div>
                </div>

                <!-- Section 3: Alumni -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right" data-aos-duration="600" class="lg:pr-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-1 h-8 bg-emerald-500 rounded-full"></span>
                            <h3 class="text-2xl font-bold tracking-tight text-white">Alumni</h3>
                        </div>
                        <p class="text-slate-350 text-base leading-relaxed">
                            Though they've stepped beyond our gates, our alumni remain deeply connected. As achievers across
                            fields and continents, they carry forward the values and vision of our school - and often give
                            back to guide those who follow.
                        </p>
                    </div>
                    <div class="flex justify-center lg:justify-end" data-aos="fade-left" data-aos-duration="600">
                        <div class="w-full max-w-[400px] bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl shadow-xl hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-300"></div>
                            <div class="flex justify-center mb-4">
                                <GraduationCapIcon class="size-16 text-emerald-400 group-hover:scale-110 transition-transform duration-300" />
                            </div>
                            <p class="text-center text-6xl font-black bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent select-none">
                                <Vue3Autocounter ref="alumniRef" :startAmount='0' :endAmount='5123' :duration='1.5' suffix='+' />
                            </p>
                            <p class="text-center text-slate-400 text-xs font-semibold uppercase tracking-wider mt-2">Graduated Alumni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>