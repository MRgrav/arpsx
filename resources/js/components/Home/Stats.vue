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
    <div class="bg-gradient-to-b p-8 py-16">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-center text-[#4e71ff] py-10" data-aos="fade-in">Heart of Our Success</h2>

            <!-- hide on mobile and tablate -->
            <div class="flex flex-col-reverse lg:grid grid-cols-2 gap-4 py-10">
                <div data-aos="fade-right" data-aos-duration="400">
                    <h3
                        class="text-[var(--primary-brand-500)] border-[var(--primary-brand-500)] p-3 mb-2 border-b-1 border-l-5">
                        Teachers & Staffs
                    </h3>
                    <p class="text-gray-500">
                        Behind every successful student is a team of dedicated educators and professionals. Our teachers
                        inspire learning with passion and purpose, while our support staff ensures a safe, efficient,
                        and
                        welcoming environment for all.
                    </p>
                </div>
                <div class="flex flex-col" data-aos="fade-left" data-aos-duration="400">
                    <div class="flex justify-center">
                        <svg class="size-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
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
                    <p class="text-center text-6xl font-bold text-purple-500">
                        <Vue3Autocounter ref="teachersRef" :startAmount='0' :endAmount='71' :duration='1' suffix='+' />
                    </p>
                </div>
            </div>
            <div class="flex flex-col lg:grid grid-cols-2 gap-4 py-10">
                <div class="flex flex-col" data-aos="fade-right" data-aos-duration="400">
                    <div class="flex justify-center">
                        <UserPen class="size-20" />
                    </div>
                    <p class="text-center text-6xl font-bold text-purple-500">
                        <Vue3Autocounter ref="studentsRef" :startAmount='0' :endAmount='712' :duration='1' suffix='+' />
                    </p>
                </div>
                <div data-aos="fade-left" data-aos-duration="400">
                    <h3
                        class="text-[var(--primary-brand-500)] border-[var(--primary-brand-500)] p-3 mb-2 border-b-1 border-r-5 text-end">
                        Students
                    </h3>
                    <p class="text-gray-500">
                        Curious minds, bright ideas, and boundless energy — our students bring life to the campus every
                        day. With opportunities to lead, create, and grow, they embody the spirit of learning in every
                        corner of the school.
                    </p>
                </div>
            </div>
            <div class="flex flex-col-reverse lg:grid grid-cols-2 gap-4 py-10">
                <div data-aos="fade-right" data-aos-duration="400">
                    <h3
                        class="text-[var(--primary-brand-500)] border-[var(--primary-brand-500)] p-3 mb-2 border-b-1 border-l-5">
                        Alumni
                    </h3>
                    <p class="text-gray-500">
                        Though they've stepped beyond our gates, our alumni remain deeply connected. As achievers across
                        fields and continents, they carry forward the values and vision of our school - and often give
                        back to guide those who follow.
                    </p>
                </div>
                <div class="flex flex-col" data-aos="fade-left" data-aos-duration="400">
                    <div class="flex justify-center">
                        <GraduationCapIcon class="size-20" />
                    </div>
                    <p class="text-center text-6xl font-bold text-purple-500">
                        <Vue3Autocounter ref="alumniRef" :startAmount='0' :endAmount='5123' :duration='1' suffix='+' />
                    </p>
                </div>
            </div>
        </div>

    </div>
</template>