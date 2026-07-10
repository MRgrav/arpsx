<script setup lang="ts">
import { ref } from 'vue';
import { Users, GraduationCap, Briefcase } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const tabs = [
    { name: 'Our Faculties', key: 'faculties', link: '/faculty', icon: Users },
    { name: 'Our Students', key: 'students', link: '/academic-achievements', icon: GraduationCap },
    { name: 'Our Staffs', key: 'staffs', link: '/staff', icon: Briefcase }
]

const activeTab = ref(tabs[0])

const members = {
    faculties: {
        name: 'Dr. A. Sharma',
        role: 'Principal',
        img: 'hero-1.webp',
        message: 'Our experienced educators across diverse departments are committed to nurturing curiosity, critical thinking, and academic excellence. Each member brings unique skills and passion to create a supportive learning environment.'
    },
    students: {
        name: 'Rahul Singh',
        role: 'Class 10',
        img: 'hero-3.webp',
        message: 'At our school, students find not just education but a second home. With guidance, care, and opportunities to grow, we carry forward values, friendships, and memories that last a lifetime.',
    },
    staffs: {
        name: 'Sanjay Kumar',
        role: 'Admin Staff',
        img: 'hero-4.webp',
        message: 'Alongside our teachers, our non-teaching staff play an important role in keeping the school running smoothly. With their constant support, care, and dedication, they help create a safe and welcoming environment for every student.',
    }
}
</script>

<template>
    <section
        class="py-16 px-8 bg-zinc-50 relative bg-[radial-gradient(circle,_rgba(0,0,0,0.1)_1px,_transparent_1px)] [background-size:12px_12px]">
        <div class="max-w-7xl mx-auto">

            <!-- Section Heading -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="font-extrabold text-[#4e71ff] mb-4 animate-fadeInUp">Our School Family</h2>
                <p class="max-w-2xl mx-auto text-gray-600 animate-fadeIn delay-200">
                    Meet the people who make our school a vibrant and nurturing place — from inspiring faculty to
                    dedicated staff and brilliant students.
                </p>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center gap-4 flex-wrap p-4" data-aos="zoom-in">
                <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab"
                    class="flex items-center gap-2 px-5 py-3 rounded-full text-sm font-medium shadow-sm transition-all duration-300 hover:scale-110"
                    :class="activeTab.key === tab.key
                        ? 'bg-[#4e71ff] text-white shadow-lg scale-105'
                        : 'bg-white text-gray-600 hover:bg-blue-50'">
                    <component :is="tab.icon" class="w-4 h-4" />
                    {{ tab.name }}
                </button>
            </div>

            <div v-for="(member, index) in members" :key="index">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-white/70 backdrop-blur-md border border-slate-200/60 my-10 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-500" v-if="activeTab.key === index">
                    <div class="col-span-1 p-6 lg:p-8 overflow-hidden w-full h-[400px]" data-aos="fade-right" data-aos-duration="500"
                        data-aos-easing="ease-in-out">
                        <img :src="`/storage/uploads/${member.img}`" :alt="member.name"
                            class="h-full w-full object-cover rounded-2xl shadow-md transition-transform duration-500 hover:scale-102">
                    </div>
                    <div class="col-span-1 flex flex-col justify-center gap-5 p-8 lg:p-12" data-aos="fade-left"
                        data-aos-duration="500" data-aos-easing="ease-in-out">
                        <span class="text-blue-600 text-xs font-bold uppercase tracking-widest bg-blue-100 px-3 py-1 rounded-full border border-blue-200 w-fit">School Community</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ activeTab.name }}</h3>
                        <p class="text-slate-600 leading-relaxed font-medium">
                            {{ member.message }}
                        </p>
                        <Link :href="activeTab.link" class="w-fit mt-4">
                        <button class="flex gap-4 learn-more space-x-4">
                            <span class="circle me-4" aria-hidden="true">
                                <span class="icon arrow"></span>
                            </span>
                            <span class="button-text">Explore Directory</span>
                        </button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Tailwind animations using keyframes */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(5px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.8s ease forwards;
}

.animate-fadeIn {
    animation: fadeIn 1s ease forwards;
}

.learn-more {
    position: relative;
    display: inline-block;
    cursor: pointer;
    outline: none;
    /* border: 0; */
    vertical-align: middle;
    text-decoration: none;
    padding: 0;
    font-size: inherit;
    font-family: inherit;
    width: 12rem;
    height: auto;
    background-color: rgba(78, 113, 255, 0.1);
    border-radius: 1.625rem;
}

.learn-more .circle {
    transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
    position: relative;
    display: block;
    margin: 0;
    width: 3rem;
    height: 3rem;
    background: #4e71ff;
    border-radius: 1.625rem;
}

.learn-more .circle .icon {
    transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    background: #fff;
}

.learn-more .circle .icon.arrow {
    transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
    left: 0.625rem;
    width: 1.125rem;
    height: 0.125rem;
    background: none;
}

.learn-more .circle .icon.arrow::before {
    position: absolute;
    content: "";
    top: -0.29rem;
    right: 0.0625rem;
    width: 0.625rem;
    height: 0.625rem;
    border-top: 0.125rem solid #fff;
    border-right: 0.125rem solid #fff;
    transform: rotate(45deg);
}

.learn-more .button-text {
    transition: all 0.3s cubic-bezier(0.65, 0, 0.076, 1);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 0.75rem 0;
    margin: 0 0 0 1.85rem;
    color: #282936;
    font-weight: 700;
    line-height: 1.6;
    text-align: center;
    text-transform: uppercase;
}

.learn-more:hover .circle {
    width: 100%;
}

.learn-more:hover .circle .icon.arrow {
    background: #fff;
    transform: translate(1rem, 0);
}

.learn-more:hover .button-text {
    color: #fff;
}
</style>