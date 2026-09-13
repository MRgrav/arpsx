<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import Button from '@/components/ui/button/Button.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'User Permissions',
    href: '/school-admin/users',
  },
];

interface Permission {
  id: number;
  name: string;
  display_name: string;
  group: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
  permissions?: Permission[];
}

interface Props {
  users: User[];
}

const props = defineProps<Props>();
</script>

<template>
  <Head title="User Permissions"></Head>

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">User Permissions Management</h1>

      <Table>
        <TableCaption>List of registered users and their assigned permissions.</TableCaption>
        <TableHeader>
          <TableRow>
            <TableHead>User</TableHead>
            <TableHead>Email</TableHead>
            <TableHead>Type / Role</TableHead>
            <TableHead>Permissions Count</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="user in props.users" :key="user.id">
            <TableCell class="font-medium">{{ user.name }}</TableCell>
            <TableCell>{{ user.email }}</TableCell>
            <TableCell>
              <span v-if="user.is_admin" class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full dark:bg-purple-900 dark:text-purple-200">
                Super Admin
              </span>
              <span v-else class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full dark:bg-blue-900 dark:text-blue-200">
                Staff / User
              </span>
            </TableCell>
            <TableCell>
              <span v-if="user.is_admin" class="text-gray-500 italic">All (Super Admin)</span>
              <span v-else>{{ user.permissions?.length || 0 }} permission(s)</span>
            </TableCell>
            <TableCell class="text-right">
              <Link v-if="!user.is_admin" :href="`/school-admin/users/${user.id}/permissions`">
                <Button variant="outline" size="sm">Manage Permissions</Button>
              </Link>
              <span v-else class="text-xs text-gray-400">Full Access</span>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </SchoolAdminLayout>
</template>
