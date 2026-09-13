<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';

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
    title: 'Add New User',
    href: '/school-admin/users/create',
  },
];

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  is_admin: false,
});

const submit = () => {
  form.post('/school-admin/users');
};
</script>

<template>
  <Head title="Add New User"></Head>

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 max-w-3xl mx-auto w-full">
      <div class="flex items-center justify-between border-b pb-4">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">
          Add New User
        </h1>
      </div>

      <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border">
        
        <div class="space-y-2">
          <Label for="name">Name</Label>
          <Input id="name" v-model="form.name" type="text" required autofocus />
          <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="space-y-2">
          <Label for="email">Email</Label>
          <Input id="email" v-model="form.email" type="email" required />
          <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password">Password</Label>
          <Input id="password" v-model="form.password" type="password" required />
          <p v-if="form.errors.password" class="text-sm text-red-500">{{ form.errors.password }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password_confirmation">Confirm Password</Label>
          <Input id="password_confirmation" v-model="form.password_confirmation" type="password" required />
        </div>

        <div class="flex items-center space-x-2 pt-2">
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

        <div class="flex justify-end pt-4 border-t">
          <Button type="submit" :disabled="form.processing">Create User</Button>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
