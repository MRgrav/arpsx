<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { 
  GraduationCapIcon, 
  User, 
  University, 
  Activity, 
  Settings, 
  Plus
} from 'lucide-vue-next';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/school-admin/dashboard',
    },
];

interface DailyStat {
  date: string;
  label: string;
  standard: number;
  hs: number;
}

const props = defineProps<{
    total_registrations: number;
    total_hs_registrations: number;
    total_staffs: number;
    total_departments: number;
    total_registrations_this_month: number;
    total_hs_registrations_this_month: number;
    registration_enabled: boolean;
    hs_registration_enabled: boolean;
    daily_stats: DailyStat[];
}>();

// Calculate maximum daily count for chart scaling
const maxDailyCount = computed(() => {
  let max = 0;
  props.daily_stats.forEach(d => {
    const total = (d.standard || 0) + (d.hs || 0);
    if (total > max) max = total;
  });
  return max > 0 ? max : 10; // Fallback minimum scale
});

const isAnyFormEnabled = computed(() => props.registration_enabled || props.hs_registration_enabled);
</script>

<template>
    <Head title="Admin Dashboard" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8 space-y-8 text-slate-800 dark:text-zinc-50 bg-sky-50/10 dark:bg-zinc-950/10 rounded-2xl border border-sky-100/20 dark:border-zinc-900">
            
            <!-- Minimalist Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-sky-100/50 dark:border-zinc-900 pb-6">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-zinc-50">Dashboard</h1>
                    <p class="text-sm text-slate-500 dark:text-zinc-400 mt-1">Overview of application campaigns and system metrics.</p>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="'/school-admin/settings'">
                        <button class="flex items-center gap-2 px-3 py-1.5 border border-sky-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900/50 hover:bg-sky-50/50 dark:hover:bg-zinc-800 rounded-lg text-xs font-medium text-slate-600 dark:text-zinc-300 transition">
                            <Settings class="size-3.5 text-slate-500 dark:text-zinc-400" />
                            Settings
                        </button>
                    </Link>
                </div>
            </div>

            <!-- Portal Status Indicator Banners -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center justify-between p-4 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:border-sky-200 dark:hover:border-sky-900/40 transition duration-300">
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">Standard Registration</span>
                        <h2 class="text-sm font-medium text-slate-800 dark:text-zinc-200">Standard Admissions Form</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" 
                          :class="props.registration_enabled ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400' : 'bg-slate-100 dark:bg-zinc-900 text-slate-600 dark:text-zinc-400'">
                        <span class="w-1.5 h-1.5 rounded-full" :class="props.registration_enabled ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400'"></span>
                        {{ props.registration_enabled ? 'Portal Active' : 'Portal Closed' }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:border-sky-200 dark:hover:border-sky-900/40 transition duration-300">
                    <div class="space-y-0.5">
                        <span class="text-xs font-semibold text-slate-400 dark:text-zinc-500 uppercase tracking-wider">HS Registration</span>
                        <h2 class="text-sm font-medium text-slate-800 dark:text-zinc-200">Higher Secondary Admissions</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" 
                          :class="props.hs_registration_enabled ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400' : 'bg-slate-100 dark:bg-zinc-900 text-slate-600 dark:text-zinc-400'">
                        <span class="w-1.5 h-1.5 rounded-full" :class="props.hs_registration_enabled ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400'"></span>
                        {{ props.hs_registration_enabled ? 'Portal Active' : 'Portal Closed' }}
                    </span>
                </div>
            </div>

            <!-- Minimal Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Standard Total -->
                <Link :href="'/school-admin/registrations'" class="block p-6 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-sm hover:shadow transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-center text-slate-400 dark:text-zinc-500">
                        <span class="text-xs font-semibold uppercase tracking-wider">Standard Total</span>
                        <GraduationCapIcon class="size-4" />
                    </div>
                    <div class="space-y-1">
                        <span class="text-3xl font-light tracking-tight text-slate-900 dark:text-zinc-50">{{ props.total_registrations || 0 }}</span>
                        <p class="text-xs text-slate-400 dark:text-zinc-500 flex items-center gap-1">
                            <span class="text-emerald-500 font-medium">+{{ props.total_registrations_this_month || 0 }}</span> this month
                        </p>
                    </div>
                </Link>

                <!-- Card 2: HS Total -->
                <Link :href="'/school-admin/hs-registrations'" class="block p-6 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-sm hover:shadow transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-center text-slate-400 dark:text-zinc-500">
                        <span class="text-xs font-semibold uppercase tracking-wider">HS Total</span>
                        <GraduationCapIcon class="size-4" />
                    </div>
                    <div class="space-y-1">
                        <span class="text-3xl font-light tracking-tight text-slate-900 dark:text-zinc-50">{{ props.total_hs_registrations || 0 }}</span>
                        <p class="text-xs text-slate-400 dark:text-zinc-500 flex items-center gap-1">
                            <span class="text-emerald-500 font-medium">+{{ props.total_hs_registrations_this_month || 0 }}</span> this month
                        </p>
                    </div>
                </Link>

                <!-- Card 3: Staffs -->
                <Link :href="'/school-admin/profiles'" class="block p-6 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-sm hover:shadow transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-center text-slate-400 dark:text-zinc-500">
                        <span class="text-xs font-semibold uppercase tracking-wider">Staffs</span>
                        <User class="size-4" />
                    </div>
                    <div class="space-y-1">
                        <span class="text-3xl font-light tracking-tight text-slate-900 dark:text-zinc-50">{{ props.total_staffs || 0 }}</span>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">registered accounts</p>
                    </div>
                </Link>

                <!-- Card 4: Departments -->
                <Link :href="'/school-admin/departments'" class="block p-6 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-sm hover:shadow transition-all duration-300 space-y-4">
                    <div class="flex justify-between items-center text-slate-400 dark:text-zinc-500">
                        <span class="text-xs font-semibold uppercase tracking-wider">Departments</span>
                        <University class="size-4" />
                    </div>
                    <div class="space-y-1">
                        <span class="text-3xl font-light tracking-tight text-slate-900 dark:text-zinc-50">{{ props.total_departments || 0 }}</span>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">academic divisions</p>
                    </div>
                </Link>
            </div>

            <!-- Dynamic Day-Wise Bar Chart (Shown if Portals are Active/Open) -->
            <div v-if="isAnyFormEnabled" class="p-6 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 space-y-6">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="space-y-1">
                        <h2 class="text-base font-medium flex items-center gap-2 text-slate-900 dark:text-zinc-50">
                            <Activity class="size-4 text-sky-500" />
                            Daily Registration Campaign Traffic
                        </h2>
                        <p class="text-xs text-slate-400">Real-time daily submissions timeline over the last 30 days.</p>
                    </div>

                    <!-- Chart Legend -->
                    <div class="flex items-center gap-4 text-xs font-medium">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded bg-zinc-800 dark:bg-zinc-100 block"></span>
                            <span class="text-slate-500 dark:text-zinc-400">Standard</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded bg-indigo-500 block"></span>
                            <span class="text-slate-500 dark:text-zinc-400">HS</span>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Bar Chart Grid -->
                <div class="w-full overflow-x-auto pb-4">
                    <div class="min-w-[640px] h-60 flex items-end gap-3 px-2 border-b border-sky-100/50 dark:border-zinc-900/60 pb-2 relative">
                        
                        <!-- Horizontal Grid Guides -->
                        <div class="absolute inset-x-0 bottom-2 top-0 flex flex-col justify-between pointer-events-none select-none opacity-40">
                            <div class="border-b border-dashed border-sky-100/30 dark:border-zinc-800/80 w-full h-0"></div>
                            <div class="border-b border-dashed border-sky-100/30 dark:border-zinc-800/80 w-full h-0"></div>
                            <div class="border-b border-dashed border-sky-100/30 dark:border-zinc-800/80 w-full h-0"></div>
                        </div>

                        <!-- Bar Columns -->
                        <div v-for="(day, index) in props.daily_stats" :key="day.date" 
                             class="flex-1 flex flex-col items-center justify-end h-full group relative cursor-pointer z-10">
                            
                            <!-- Detailed Floating Tooltip -->
                            <div class="absolute bottom-full mb-3 bg-zinc-950 dark:bg-zinc-900 text-white border border-zinc-850 rounded-lg p-2.5 text-[10px] space-y-1 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg z-50 whitespace-nowrap">
                                <p class="font-bold border-b border-zinc-800 pb-1 mb-1">{{ day.label }}</p>
                                <p class="flex justify-between gap-4">Standard: <span class="font-semibold">{{ day.standard }}</span></p>
                                <p class="flex justify-between gap-4">Higher Secondary: <span class="font-semibold text-indigo-400">{{ day.hs }}</span></p>
                                <p class="flex justify-between gap-4 border-t border-zinc-800 pt-1 mt-1 font-semibold text-zinc-300">Total: <span>{{ day.standard + day.hs }}</span></p>
                            </div>

                            <!-- Dual Stacked Bars -->
                            <div class="w-3.5 sm:w-4 flex flex-col justify-end items-center h-full gap-0.5">
                                <div class="w-full bg-indigo-500 rounded-t-sm transition-all duration-500 ease-out" 
                                     :style="{ height: ((day.hs || 0) / maxDailyCount) * 100 + '%' }"></div>
                                <div class="w-full bg-zinc-800 dark:bg-zinc-100 rounded-t-sm transition-all duration-500 ease-out" 
                                     :style="{ height: ((day.standard || 0) / maxDailyCount) * 100 + '%' }"></div>
                            </div>

                            <!-- X Axis Date Labels (Show every 3rd day to avoid label overlap) -->
                            <span class="absolute top-full mt-2 text-[9px] font-medium text-slate-400 dark:text-zinc-550 whitespace-nowrap transition-colors group-hover:text-slate-800 dark:group-hover:text-zinc-200">
                                {{ index % 3 === 0 || index === props.daily_stats.length - 1 ? day.label : '' }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Minimal Actions Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                <Link :href="'/school-admin/registrations'" class="p-5 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-xs hover:shadow-sm transition-all duration-300 flex items-center justify-between group">
                    <div class="space-y-0.5">
                        <h3 class="text-sm font-medium text-slate-800 dark:text-zinc-200">Standard Applicants</h3>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">View standard registrations</p>
                    </div>
                    <GraduationCapIcon class="size-4 text-slate-400 dark:text-zinc-500 group-hover:text-slate-900 dark:group-hover:text-zinc-100 transition" />
                </Link>

                <Link :href="'/school-admin/hs-registrations'" class="p-5 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-xs hover:shadow-sm transition-all duration-300 flex items-center justify-between group">
                    <div class="space-y-0.5">
                        <h3 class="text-sm font-medium text-slate-800 dark:text-zinc-200">HS Applicants</h3>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">View HS registrations</p>
                    </div>
                    <GraduationCapIcon class="size-4 text-slate-400 dark:text-zinc-500 group-hover:text-slate-900 dark:group-hover:text-zinc-100 transition" />
                </Link>

                <Link :href="'/school-admin/posts/create'" class="p-5 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-xs hover:shadow-sm transition-all duration-300 flex items-center justify-between group">
                    <div class="space-y-0.5">
                        <h3 class="text-sm font-medium text-slate-800 dark:text-zinc-200">Add Post</h3>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">Publish announcements</p>
                    </div>
                    <Plus class="size-4 text-slate-400 dark:text-zinc-500 group-hover:text-slate-900 dark:group-hover:text-zinc-100 transition" />
                </Link>

                <Link :href="'/school-admin/notifications/create'" class="p-5 rounded-xl border border-sky-100/60 dark:border-sky-950/30 bg-sky-50/40 dark:bg-sky-950/10 hover:bg-sky-50/80 dark:hover:bg-sky-950/20 hover:border-sky-200/80 dark:hover:border-sky-900/40 hover:-translate-y-0.5 shadow-xs hover:shadow-sm transition-all duration-300 flex items-center justify-between group">
                    <div class="space-y-0.5">
                        <h3 class="text-sm font-medium text-slate-800 dark:text-zinc-200">Broadcast Alert</h3>
                        <p class="text-xs text-slate-400 dark:text-zinc-500">Create global layout notice</p>
                    </div>
                    <Plus class="size-4 text-slate-400 dark:text-zinc-500 group-hover:text-slate-900 dark:group-hover:text-zinc-100 transition" />
                </Link>
            </div>

        </div>
    </SchoolAdminLayout>
</template>
