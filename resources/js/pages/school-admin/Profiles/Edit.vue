<script setup lang="ts">
import { Input } from '@/components/ui/input';
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { Department, Profile, Role, type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Select, SelectTrigger, SelectValue, SelectContent, SelectGroup, SelectItem } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
const defaultProfileIcon = '/images/defaults/profile.png';

const props = defineProps<{
  profile: Profile,
  roles: Role[],
  departments: Department[],
}>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Profiles', href: '/school-admin/profiles' },
  { title: 'Edit', href: `/school-admin/profiles/${props.profile.id}/edit` },
];

// Use Inertia's form helper
const form = useForm({
  name: props.profile.name ?? '',
  role_id: props.profile.role_id ?? '',
  position: props.profile.position ?? '',
  department_id: props.profile.department_id ?? '',
  detail: props.profile.detail ?? '',
  message: props.profile.message ?? '',
  image: null,
  is_hod: props.profile.is_hod ?? false,
});

const submit = () => {
  form.post(`/school-admin/profiles/${props.profile.id}/update`);
};

const getProfileImageUrl = () => {
  const img = props.profile.image;
  if (!img || img === 'null' || img === 'undefined' || img.trim() === '') {
    return defaultProfileIcon;
  }
  if (img.startsWith('http://') || img.startsWith('https://')) {
    return img;
  }
  return `/storage/uploads/${img}`;
};
</script>

<template>
  <Head title="Edit Profile"></Head>

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="bg-white rounded shadow p-8">
      <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Name -->
        <div>
          <label class="block font-medium">Name</label>
          <Input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
          <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>

        <!-- Role -->
        <div>
          <label class="block font-medium">Role</label>
            <Select v-model="form.role_id">
              <SelectTrigger class="form-select w-full">
                <SelectValue placeholder="-- Select --" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectItem v-for="role in $props.roles" :key="role.id" :value="role.id">{{ role.display_name }}</SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
          <div v-if="form.errors.role_id" class="text-red-500 text-sm">{{ form.errors.role_id }}</div>
        </div>

        <!-- Position -->
        <div>
          <label class="block font-medium">Position</label>
          <Input v-model="form.position" type="text" class="w-full border rounded px-3 py-2" />
        </div>

        <!-- Department -->
        <div>
          <label class="block font-medium">Department</label>

            <Select v-model="form.department_id">
              <SelectTrigger class="form-select w-full">
                <SelectValue placeholder="-- Select --" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectItem :value="null">None</SelectItem>
                  <SelectItem v-for="department in $props.departments" :key="department.id" :value="department.id">{{ department.display_name }}</SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>

          <div v-if="form.errors.department_id" class="text-red-500 text-sm">
            {{ form.errors.department_id }}
          </div>
        </div>

        <!-- Is HOD Checkbox -->
        <div class="flex items-center gap-2 py-1">
          <input id="is_hod" type="checkbox" v-model="form.is_hod" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
          <label for="is_hod" class="font-medium text-gray-700 select-none">Make this staff member Head of Department (HOD)</label>
        </div>

        <!-- Detail -->
        <div>
          <label class="block font-medium">Detail</label>
          <Textarea v-model="form.detail" class="w-full border rounded px-3 py-2"></Textarea>
        </div>

        <!-- Message -->
        <div>
          <label class="block font-medium">Message</label>
          <Textarea v-model="form.message" rows="10" class="w-full border rounded px-3 py-2"></Textarea>
        </div>

        <!-- Image Upload -->
        <div>
          <label class="block font-medium">Profile Image</label>
          <Input type="file" @Input="form.image = $event.target.files[0]"/>
          <div v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</div>

          <div class="mt-2">
            <img :src="getProfileImageUrl()" alt="Current Profile" class="w-20 h-20 rounded-full object-cover" />
          </div>
        </div>

        <!-- Submit -->
        <div class="flex space-x-2">
          <Button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Saving...' : 'Save Changes' }}
          </Button>

          <Link href="/school-admin/profiles" class="px-4 py-2 rounded border border-gray-300">
            Cancel
          </Link>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
