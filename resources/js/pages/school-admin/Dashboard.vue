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
    total_staffs: number
    total_departments: number
}>();

</script>

<template>

    <Head title="Dashboard" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <h1>Admin Dashboard</h1>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card
                    class="bg-gradient-to-br from-blue-50 to-white aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/registrations'" class="block">
                    <h3 class="text-center">Registrations</h3>
                    <br>
                    <div class="flex items-center justify-center gap-10">
                        <GraduationCapIcon class="size-13" />
                        <span class="font-bold text-5xl">{{ props.total_registrations || 0 }}</span>
                    </div>
                    </Link>
                    </CardContent>
                </Card>

                <Card
                    class="bg-gradient-to-br from-blue-50 to-white aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/profiles'" class="block">
                    <h3 class="text-center">Staffs</h3>
                    <br>
                    <div class="flex items-center justify-center gap-10">
                        <User class="size-13" />
                        <span class="font-bold text-5xl">{{ props.total_staffs || 0 }}</span>
                    </div>
                    </Link>
                    </CardContent>
                </Card>
                <Card
                    class="bg-gradient-to-br from-blue-50 to-white aspect-video border border-sidebar-border/70 dark:border-sidebar-border hover:shadow">
                    <CardContent class="relative overflow-hidden">
                        <!-- <PlaceholderPattern /> -->
                    <Link :href="'/school-admin/departments'" class="block">
                    <h3 class="text-center">Departments</h3>
                    <br>
                    <div class="flex items-center justify-center gap-10">
                        <University class="size-13" />
                        <span class="font-bold text-5xl">{{ props.total_departments || 0 }}</span>
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
