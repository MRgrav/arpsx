<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
// import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { PenBoxIcon, GraduationCapIcon, User, University } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/school-admin/dashboard',
    },
];

const props = defineProps<{
    total_registrations: number
    total_hs_registrations: number
    total_staffs: number
    total_departments: number
    total_registrations_this_month: number
    total_hs_registrations_this_month: number
}>();

</script>

<template>

    <Head title="Dashboard" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <h1>Admin Dashboard</h1>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">
                <Card
                    class="bg-gradient-to-br from-blue-300 to-blue-200 aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/registrations'" class="block">
                    <h4 class="text-left">Registrations</h4>
                    <br>
                    <div class="flex items-center justify-start gap-10 mb-6">
                        <GraduationCapIcon class="size-13" />
                        <span class="font-bold text-5xl">{{ props.total_registrations || 0 }}</span>
                    </div>
                    <div class="text-end text-green-700 text-lg mt-auto min-mt-4 mb-2">
                        <span><b>{{ props.total_registrations_this_month || 0 }}</b> this month</span>
                    </div>
                    </Link>
                    </CardContent>
                </Card>

                <Card
                    class="bg-gradient-to-br from-blue-300 to-blue-200 aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                        <Link :href="'/school-admin/registrations'" class="block">
                        <h4 class="text-left truncate">HS Registrations</h4>
                        <br>
                        <div class="flex items-center justify-start gap-10 mb-6">
                            <GraduationCapIcon class="size-13" />
                            <span class="font-bold text-5xl">{{ props.total_hs_registrations || 0 }}</span>
                        </div>
                        <div class=" text-end text-green-700 text-lg mt-auto min-mt-4 mb-2">
                            <span><b>{{ props.total_hs_registrations_this_month || 0 }}</b> this month</span>
                        </div>
                        </Link>
                    </CardContent>
                </Card>

            </div>
            
            <div class="flex flex-wrap gap-2 py-6">
                <Card class="bg-blue-200/60 min-w-[200px] py-4">
                    <CardContent>
                        <Link :href="'/school-admin/profiles'" class="flex gap-6">
                            <div class="bg-black/20 flex justify-center items-center aspect-square rounded p-3">
                                <User class="size-8" />
                            </div>
                            <div class="flex flex-col justify-start items-start">
                                <p>Staffs</p>
                                <p class="text-xl font-semibold">{{ props.total_staffs || 0 }}</p>
                            </div>
                        </Link>
                    </CardContent>
                </Card>
                <Card class="bg-blue-200/60 min-w-[200px] py-4">
                    <CardContent>
                        <Link :href="'/school-admin/departments'" class="flex gap-6">
                            <div class="bg-black/20 flex justify-center items-center aspect-square rounded p-3">
                                <University class="size-8" />
                            </div>
                            <div class="flex flex-col justify-start items-start">
                                <p>Departments</p>
                                <p class="text-xl font-semibold">{{ props.total_departments || 0 }}</p>
                            </div>
                        </Link>
                    </CardContent>
                </Card>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-10">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/posts/create'" class="flex flex-row-reverse items-center gap-4 p-6 block">
                    <h4 class="text-center">Create Post</h4>
                    <PenBoxIcon class="size-8" />
                    </Link>
                </div>
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/notifications/create'" class="flex flex-row-reverse items-center gap-4 p-6 block">
                    <h4 class="text-center">Add Notification</h4>
                    <PenBoxIcon class="size-8" />
                    </Link>
                </div>
                <!-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />

                </div> -->
            </div>

            <!-- <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div> -->
        </div>
    </SchoolAdminLayout>
</template>
