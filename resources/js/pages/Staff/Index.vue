<script setup lang="ts">
import FacultyCard from '@/components/Faculty/FacultyCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Profile, Role } from '@/types';

interface Props {
    roles: Role[],
    profiles: Profile[]
}

const props = defineProps<Props>();
</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="font-bold mb-4">Our Staffs</h1>
                <p class=" mx-auto text-gray-500 leading-relaxed">
                    Our non-teaching staff form an integral part of the school community. From handling administration, accounts, and library services to maintaining the campus and assisting in day-to-day operations, they ensure that the learning environment remains organized and welcoming. Their dedication often works behind the scenes, but it plays a vital role in supporting both students and teachers. With their care and commitment, our school continues to function smoothly and efficiently every single day.
                </p>

                <div class="space-y-4 mt-10">
                    <div v-for="role in props.roles" :key="role.id">
                        <div v-if="role.profiles_count">
                            <h2 class="text-center bg-gray-100 p-6">
                                {{ role.display_name }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 rounded py-5">
                                <FacultyCard  v-for="profile in props.profiles.filter(p => p.role_id === role.id)" :key="profile.id" :profile="profile" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
