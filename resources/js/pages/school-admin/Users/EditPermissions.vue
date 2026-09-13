<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';

const props = defineProps<{
  user: {
    id: number;
    name: string;
    email: string;
  };
  userPermissions: number[];
  permissionsByGroup: Record<string, Array<{ id: number; name: string; display_name: string; group: string }>>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'User Permissions',
    href: '/school-admin/users',
  },
  {
    title: props.user.name,
    href: `/school-admin/users/${props.user.id}/permissions`,
  },
];

const form = useForm({
  permissions: [...props.userPermissions],
});

const togglePermission = (id: number) => {
  const index = form.permissions.indexOf(id);
  if (index > -1) {
    form.permissions.splice(index, 1);
  } else {
    form.permissions.push(id);
  }
};

const submit = () => {
  form.post(`/school-admin/users/${props.user.id}/permissions`);
};
</script>

<template>
  <Head :title="`Edit Permissions - ${user.name}`"></Head>

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
      <div class="flex items-center justify-between border-b pb-4">
        <div>
          <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">
            Manage Permissions for {{ user.name }}
          </h1>
          <p class="text-sm text-gray-500">{{ user.email }}</p>
        </div>
        <Button @click="submit" :disabled="form.processing">
          Save Permissions
        </Button>
      </div>

      <div class="space-y-6">
        <div 
          v-for="(permissions, group) in permissionsByGroup" 
          :key="group" 
          class="rounded-lg border p-4 bg-white dark:bg-gray-800 shadow-sm"
        >
          <h2 class="font-semibold text-lg text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">
            {{ group }}
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <label
              v-for="perm in permissions"
              :key="perm.id"
              class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
            >
              <input
                type="checkbox"
                :value="perm.id"
                :checked="form.permissions.includes(perm.id)"
                @change="togglePermission(perm.id)"
                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600"
              />
              <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ perm.display_name }}
              </span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </SchoolAdminLayout>
</template>
