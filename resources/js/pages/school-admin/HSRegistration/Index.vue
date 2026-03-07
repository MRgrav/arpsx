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

                    <Table>
                        <TableCaption>A list of your recent Registrations for HS Admission.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Phone</TableHead>
                                <TableHead>Percentage</TableHead>
                                <TableHead>Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="hsRegistration in props.hsRegistrations" :key="hsRegistration.id">
                                <TableCell class="capitalize">{{ hsRegistration.name }}</TableCell>
                                <TableCell>{{ hsRegistration.email }}</TableCell>
                                <TableCell>{{ hsRegistration.contact_number }}</TableCell>
                                <TableCell class="font-bold">{{ hsRegistration.pre_borad_percentage ?? 0 }}%</TableCell>
                                <TableCell class="text-right space-x-2">
                                    <Link :href="`/school-admin/hs-registrations/${hsRegistration.id}`">
                                        <Button>View</Button>
                                    </Link>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
        </div>  
    </SchoolAdminLayout>
</template>