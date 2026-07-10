<script setup lang="ts">
import FacultyCard from '@/components/Faculty/FacultyCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import { Profile, Role } from '@/types';

interface Props {
    roles: Role[];
    profiles: Profile[];
}

const props = defineProps<Props>();

const sortedProfilesForRole = (roleId: number) => {
    return props.profiles
        .filter((p) => p.role_id === roleId)
        .sort((a, b) => {
            const aHod = a.is_hod ? 1 : 0;
            const bHod = b.is_hod ? 1 : 0;
            return bHod - aHod; // HOD (1) floats to top before non-HOD (0)
        });
};
</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Our Staff" />
        <div class="container mx-auto flex p-8 md:gap-6">
            <div class="flex-1">
                <p class="mx-auto font-serif leading-relaxed text-gray-500">
                    Our non-teaching staff form an integral part of the school community. From handling administration, accounts, and library services
                    to maintaining the campus and assisting in day-to-day operations, they ensure that the learning environment remains organized and
                    welcoming. Their dedication often works behind the scenes, but it plays a vital role in supporting both students and teachers.
                    With their care and commitment, our school continues to function smoothly and efficiently every single day.
                </p>

                <div class="mt-10 space-y-4">
                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Accountant'">
                            <h2 class="bg-gradient-to-r from-indigo-400/20 to-transparent p-6 text-xl tracking-[5px] text-blue-600">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-10 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Clerk'">
                            <h2 class="bg-gradient-to-r from-indigo-400/20 to-transparent p-6 text-xl tracking-[5px] text-blue-600">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Librarian'">
                            <h2 class="bg-gradient-to-r from-indigo-400/20 to-transparent p-6 text-xl tracking-[5px] text-blue-600">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Staff'">
                            <h2 class="bg-gradient-to-r from-indigo-400/20 to-transparent p-6 text-xl tracking-[5px] text-blue-600">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
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
