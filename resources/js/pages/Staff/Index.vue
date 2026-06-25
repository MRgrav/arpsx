<script setup lang="ts">
import FacultyCard from '@/components/Faculty/FacultyCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
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
        <div class="p-8">
            <div class="mx-auto max-w-7xl">
                <h1 class="mb-4 font-bold">Our Staffs</h1>
                <p class="mx-auto leading-relaxed text-gray-500">
                    Our non-teaching staff form an integral part of the school community. From handling administration, accounts, and library services
                    to maintaining the campus and assisting in day-to-day operations, they ensure that the learning environment remains organized and
                    welcoming. Their dedication often works behind the scenes, but it plays a vital role in supporting both students and teachers.
                    With their care and commitment, our school continues to function smoothly and efficiently every single day.
                </p>

                <div class="mt-10 space-y-4">
                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Accountant'">
                            <h2 class="bg-gray-100 p-6 text-center">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Clerk'">
                            <h2 class="bg-gray-100 p-6 text-center">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Librarian'">
                            <h2 class="bg-gray-100 p-6 text-center">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count && role.display_name === 'Staff'">
                            <h2 class="bg-gray-100 p-6 text-center">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 gap-4 rounded py-5 md:grid-cols-2 lg:grid-cols-3">
                                <FacultyCard v-for="profile in sortedProfilesForRole(role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
