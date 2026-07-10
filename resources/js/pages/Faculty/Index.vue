<script setup lang="ts">
import FacultyCard from '@/components/Faculty/FacultyCard.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Department, Profile } from '@/types';
import { Link } from 'lucide-vue-next';

interface Props {
    departments: Department[];
    profiles: Profile[];
}

const props = defineProps<Props>();

const sortedProfilesForDepartment = (deptId: number) => {
    return props.profiles
        .filter((p) => p.department_id === deptId)
        .sort((a, b) => {
            const aHod = a.is_hod ? 1 : 0;
            const bHod = b.is_hod ? 1 : 0;
            return bHod - aHod; // HOD (1) floats to top before non-HOD (0)
        });
};
</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Our Faculty" />
        <div class="container mx-auto flex p-8 md:gap-6">
            <div class="">
                <p class="mx-auto font-serif leading-relaxed text-gray-500">
                    Welcome to our faculty page, where dedication meets expertise. Our experienced educators across diverse departments are committed
                    to nurturing curiosity, critical thinking, and academic excellence. Each member brings unique skills and passion to create a
                    supportive learning environment. Explore the departments below to learn more about the professionals guiding our students toward
                    success and lifelong growth.
                </p>

                <div class="mt-10 space-y-4">
                    <div v-for="department in props.departments" :key="department.id" class="">
                        <h2 class="bg-gradient-to-r from-indigo-400/20 to-transparent p-6 text-xl tracking-[5px] text-blue-600">
                            {{ department.display_name }}
                        </h2>
                        <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3">
                            <FacultyCard v-for="profile in sortedProfilesForDepartment(department.id)" :key="profile.id" :profile="profile" />
                        </div>
                    </div>
                </div>
            </div>
            <aside class="flex flex-col min-w-52 h-fit border border-blue-100 rounded-2xl p-4 bg-white/50 backdrop-blur-md shadow-sm">
                <b class="border-b border-blue-100 pb-2 mb-4 font-bold text-blue-900 tracking-wide text-sm">Other Links</b>
                <ul class="space-y-2">
                    <li v-for="name in ['faculty', 'staff']" :key="name">
                        <a 
                            :href="'/' + name"
                            class="capitalize rounded-xl px-3 py-2 text-sm text-blue-700 hover:bg-blue-600 hover:text-white transition duration-200 block font-semibold"
                            :class="{ 'bg-blue-600 text-white': $page.url.includes(name) }"
                        >
                            {{ name }}
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
    </AppLayout>
</template>
