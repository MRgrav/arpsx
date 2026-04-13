<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { BreadcrumbItem, HSRegistration } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/school-admin/dashboard',
    },
    {
        title: 'HS Registration',
        href: '/school-admin/hs-registration',
    },
];

interface Props {
    hsRegistrations: HSRegistration[];
}
const props = defineProps<Props>();

</script>

<template>

    <Head title="HS Registration" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">HS Registrations</h1>
                <a :href="route('school-admin.hs-registration.csv')" target="_blank">
                    <Button variant="outline">Download CSV</Button>
                </a>
            </div>
            <Table>
                <TableCaption>A list of your recent Registrations for HS Admission.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Phone</TableHead>
                        <TableHead>Percentage</TableHead>
                        <TableHead>Date</TableHead>
                        <TableHead>Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="hsRegistration in props.hsRegistrations" :key="hsRegistration.id">
                        <TableCell class="capitalize">{{ hsRegistration.name }}</TableCell>
                        <TableCell>{{ hsRegistration.email }}</TableCell>
                        <TableCell>{{ hsRegistration.contact_number }}</TableCell>
                        <TableCell class="font-bold">{{ hsRegistration.pre_borad_percentage ?? 0 }}%</TableCell>
                        <TableCell>
                            {{
                                new Date(hsRegistration.created_at).toLocaleString('en-CA', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                            minute: '2-digit',
                            })
                            }}</TableCell>
                        <TableCell class="text-right space-x-2">
                            <Link :href="`/school-admin/hs-registrations/${hsRegistration.id}`">
                                <Button>View</Button>
                            </Link>
                            <Link :href="`/school-admin/hs-registrations/${hsRegistration.id}/edit`">
                                <Button>Edit</Button>
                            </Link>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </SchoolAdminLayout>
</template>