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
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <Card
                    class="bg-gradient-to-br from-blue-50 to-white aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/registrations'" class="block">
                    <h3 class="text-left">Registrations</h3>
                    <br>
                    <div class="flex items-center justify-start gap-10">
                        <GraduationCapIcon class="size-13" />
                        <span class="font-bold text-5xl">{{ props.total_registrations || 0 }}</span>
                    </div>
                    <div class="text-green-600 text-md">
                        <span><b>{{ props.total_registrations_this_month }}</b> this month</span>
                    </div>
                    </Link>
                    </CardContent>
                </Card>

                <Card
                    class="bg-gradient-to-br from-blue-50 to-white aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                        <Link :href="'/school-admin/registrations'" class="block">
                        <h3 class="text-left">HS Registrations</h3>
                        <br>
                        <div class="flex items-center justify-start gap-10">
                            <GraduationCapIcon class="size-13" />
                            <span class="font-bold text-5xl">{{ props.total_hs_registrations || 0 }}</span>
                        </div>
                        <div class="text-green-600 text-md">
                            <span><b>{{ props.total_hs_registrations_this_month }}</b> this month</span>
                        </div>
                        </Link>
                    </CardContent>
                </Card>

            </div>
            
            <div class="flex gap-2">
                <Card class="bg-yellow-300/80">
                    <CardContent>
                        <Link :href="'/school-admin/profiles'" class="flex gap-2">
                            <div class="bg-white/30 flex justify-center items-center aspect-square rounded p-1.5">
                                <User class="size-8" />
                            </div>
                            <div class="flex flex-col justify-start items-start">
                                <p class="text-lg font-semibold">Staffs</p>
                                <p>{{ props.total_staffs || 0 }}</p>
                            </div>
                        </Link>
                    </CardContent>
                </Card>
                <Card class="bg-yellow-300/80">
                    <CardContent>
                        <Link :href="'/school-admin/departments'" class="flex gap-2">
                            <div class="bg-white/30 flex justify-center items-center aspect-square rounded p-1.5">
                                <University class="size-8" />
                            </div>
                            <div class="flex flex-col justify-start items-start">
                                <p class="text-lg font-semibold">Departments</p>
                                <p>{{ props.total_departments || 0 }}</p>
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
