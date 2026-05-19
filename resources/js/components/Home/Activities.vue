<script setup lang="ts">
import nccImage from '@/../../resources/images/ncc.avif';
import nccImage_1200 from '@/../../resources/images/ncc-1200.avif';
import cultureImage from '@/../../resources/images/culture.avif';
import cultureImage_720 from '@/../../resources/images/culture-720.avif';
import sportImage from '@/../../resources/images/sport.avif';
import { Link } from '@inertiajs/vue3';


</script>
<template>
    <div class="bg-gradient-to-b from-[#6E75FF] to-[#515AE9] p-8 py-26">

        <div class="max-w-7xl mx-auto text-white">
            <h2 class="text-center py-10" data-aos="fade-in">Our Activities</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 py-10">
                <div class="flex flex-col justify-center" data-aos="fade-right" data-aos-duration="400">
                    <h3 class="border-blue-200 p-3 mb-2 border-b-1 border-l-5">
                        NCC at a Glance
                    </h3>
                    <p>
                        Behind every successful student is a team of dedicated educators and professionals. Our teachers
                        inspire learning with passion and purpose, while our support staff ensures a safe, efficient,
                        and
                        welcoming environment for all.
                    </p>
                </div>
                <Link :href="'/ncc'" class="flex flex-col" data-aos="fade-left" data-aos-duration="400">
                <img class="h-80 border border-blue-200 bg-cover object-cover bg-center bg-no-repeat border-r-4 border-b-4 transform transition duration-300 hover:scale-101 relative"
                    :src="nccImage"
                    :srcset="`${nccImage_1200} 1200w, ${nccImage} 1920w`"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    alt="NCC activity">
                </Link>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 py-10">
                <div class="flex flex-col justify-center lg:hidden" data-aos="fade-left" data-aos-duration="400">
                    <h3 class="border-blue-200 p-3 mb-2 border-b-1 border-l-5">
                        Sports at a Glance
                    </h3>
                    <p>
                        Sports are an integral part of our school’s curriculum, promoting physical fitness, teamwork,
                        and a healthy competitive spirit. Our students actively participate in various indoor and
                        outdoor games, excelling at inter-school, district, and state-level events. Through sports, we
                        nurture discipline, resilience, and all-round development.
                    </p>
                </div>
                <Link :href="'/sports'" class="flex flex-col" data-aos="fade-right" data-aos-duration="400">
                <img class="h-80 border border-blue-200 bg-cover object-cover bg-center bg-no-repeat border-r-4 border-b-4 transform transition duration-300 hover:scale-101 relative"
                    :src="sportImage" 
                    alt="Sports activity">
                </Link>
                <div class="hidden lg:flex flex-col justify-center" data-aos="fade-left" data-aos-duration="400">
                    <h3 class="border-blue-200 p-3 mb-2 border-b-1 border-l-5">
                        Sports at a Glance
                    </h3>
                    <p>
                        Sports are an integral part of our school’s curriculum, promoting physical fitness, teamwork,
                        and a healthy competitive spirit. Our students actively participate in various indoor and
                        outdoor games, excelling at inter-school, district, and state-level events. Through sports, we
                        nurture discipline, resilience, and all-round development.
                    </p>
                </div>

            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 py-10">
                <div class="flex flex-col justify-center" data-aos="fade-right" data-aos-duration="400">
                    <h3 class="border-blue-200 p-3 mb-2 border-b-1 border-l-5">
                        Cultural Activities
                    </h3>
                    <p>
                        Our school celebrates creativity through vibrant cultural programs that include music, dance,
                        drama, and art. These activities foster confidence, teamwork, and a deep appreciation for
                        tradition. Every student is encouraged to explore and showcase their unique talents.
                    </p>
                </div>
                <Link :href="'creative-performing-arts'" class="flex flex-col" data-aos="fade-left" data-aos-duration="400">
                <img class="h-80 border border-blue-200 bg-cover object-cover bg-center bg-no-repeat border-r-4 border-b-4 transform transition duration-300 hover:scale-101 relative"
                    :src="cultureImage"
                    :srcset="`${cultureImage_720} 720w, ${cultureImage} 1600w`"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    alt="Cultural activity">
                </Link>
            </div>
        </div>
    </div>
</template>