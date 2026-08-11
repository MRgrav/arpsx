<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import RegistrationForm from '@/components/OnlineRegistration/RegistrationForm.vue';

defineProps<{
    enabled?: boolean;
    registrationMessage?: string;
    availableClasses?: string[];
    availableCategories?: string[];
    availableDefenceCategories?: string[];
}>();
</script>

<template>
    <Head title="Online Registration">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppLayout>
        <div v-if="enabled === false" class="max-w-4xl mx-auto my-16 p-8 bg-white dark:bg-gray-900 rounded-xl shadow-md border border-red-100 dark:border-red-950 text-center">
            <div class="inline-flex p-3 rounded-full bg-red-50 dark:bg-red-950/30 text-red-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Registrations Closed</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ registrationMessage || 'Online registration is currently closed. Please contact the school office for more details.' }}</p>
        </div>
        <RegistrationForm 
            v-else 
            :availableClasses="availableClasses" 
            :availableCategories="availableCategories" 
            :availableDefenceCategories="availableDefenceCategories" 
        />
    </AppLayout>
</template>
