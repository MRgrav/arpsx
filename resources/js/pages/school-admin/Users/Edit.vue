<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';

const props = defineProps<{
  user: {
    id: number;
    name: string;
    email: string;
    is_admin: boolean;
  };
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'User Management',
    href: '/school-admin/users',
  },
  {
    title: `Edit ${props.user.name}`,
    href: `/school-admin/users/${props.user.id}/edit`,
  },
];

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  is_admin: props.user.is_admin,
});

const submit = () => {
  form.put(`/school-admin/users/${props.user.id}`);
};
</script>

<template>
  <Head :title="`Edit User - ${props.user.name}`"></Head>

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-3xl mx-auto w-full">
      <div class="flex items-center justify-between border-b pb-4">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">
          Edit User: {{ props.user.name }}
        </h1>
      </div>

      <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border">
        
        <div class="space-y-2">
          <Label for="name">Name</Label>
          <Input id="name" v-model="form.name" type="text" required />
          <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="space-y-2">
          <Label for="email">Email</Label>
          <Input id="email" v-model="form.email" type="email" required />
          <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
        </div>

        <div class="pt-4 border-t">
          <h3 class="text-md font-medium text-gray-700 dark:text-gray-200 mb-4">Change Password <span class="text-xs text-gray-400 font-normal">(Leave blank to keep current password)</span></h3>
          
          <div class="space-y-4">
            <div class="space-y-2">
              <Label for="password">New Password</Label>
              <Input id="password" v-model="form.password" type="password" />
              <p v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</p>
            </div>

            <div class="space-y-2">
              <Label for="password_confirmation">Confirm New Password</Label>
              <Input id="password_confirmation" v-model="form.password_confirmation" type="password" />
            </div>
          </div>
        </div>

        <div class="flex items-center space-x-2 pt-4 border-t">
          <input
            id="is_admin"
            type="checkbox"
            v-model="form.is_admin"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          />
          <Label for="is_admin" class="font-normal cursor-pointer">
            Make this user a <strong>Super Admin</strong>
          </Label>
        </div>

        <div class="flex justify-end pt-4 border-t mt-6">
          <Button type="submit" :disabled="form.processing">Save Changes</Button>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
