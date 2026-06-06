<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { Registration, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import RegistrationList from '@/components/SchoolAdmin/Registrations/RegistrationList.vue';
import Button from '@/components/ui/button/Button.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'Registrations',
    href: '/school-admin/registrations',
  },
];

interface Props {
  registrations: Registration[];
  enabled: boolean;
}
const props = defineProps<Props>();

const toggleStatus = () => {
  const newValue = !props.enabled;
  router.post(route('school-admin.settings.toggle'), {
    key: 'registration_enabled',
    value: newValue,
  }, {
    preserveScroll: true,
  });
};
</script>

<template>
    <Head title="Registrations" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
          <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Registrations</h1>
            <div class="flex items-center gap-3">
              <Button 
                type="button"
                @click="toggleStatus"
                :variant="props.enabled ? 'default' : 'destructive'"
                class="shadow-sm font-semibold transition-all duration-200"
              >
                {{ props.enabled ? 'Portal: Enabled' : 'Portal: Disabled' }}
              </Button>
              <a :href="route('school-admin.registration.csv')" target="_blank">
                <Button variant="outline">Download CSV</Button>
              </a>
            </div>
          </div>
          <RegistrationList :registrations="props.registrations"/>
        </div>

    </SchoolAdminLayout>
</template>
