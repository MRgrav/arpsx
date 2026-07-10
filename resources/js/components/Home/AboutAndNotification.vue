<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { CalendarDays, ArrowBigRight } from 'lucide-vue-next';
import type { Notification } from '@/types';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
    notifications: Notification[]
}
const props = defineProps<Props>() // Make props reactive and type-safe.



</script>


<template>
    <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-blue-950 p-8 py-20 relative overflow-hidden">
        <!-- Subtle Ambient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-2 text-white gap-12 max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col justify-center gap-6" data-aos="fade-right">
                <span class="text-blue-400 text-xs font-bold uppercase tracking-widest bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20 w-fit">About Our School</span>
                <h2 class="text-4xl font-extrabold tracking-tight">Assam Rifles Public School</h2>
                <p class="text-gray-300 leading-relaxed font-medium">
                    Established in 1977, Assam Rifles Junior School in Jorhat is a CBSE-affiliated institution
                    offering English-medium education from Nursery to Class XII. In senior secondary, we offer
                    Humanities, Commerce, and Science streams. With well-equipped classrooms, playrooms, music and
                    computer labs, and sports facilities, we foster creativity and learning.
                </p>
                <p class="text-gray-400 leading-relaxed">
                    Our dedicated team of teachers supports both academic and emotional growth, ensuring a well-rounded
                    development — helping our students build a strong foundation for the future.
                </p>
            </div>
            
            <div class="bg-[url('/storage/uploads/hero-1.webp')] bg-cover bg-center rounded-3xl overflow-hidden shadow-2xl border border-white/10 relative" data-aos="fade-left">
                <div class="bg-indigo-950/75 p-8 lg:p-10 backdrop-blur-md h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="w-2.5 h-8 bg-blue-500 rounded-full"></span>
                            <h2 class="text-2xl font-bold tracking-tight">Notifications</h2>
                        </div>
                        
                        <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                            <div v-for="notification in props.notifications" :key="notification.id" class="group/item">
                                <Link :href="`/notifications/${notification.id}`" class="block bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/15 rounded-2xl p-5 transition-all duration-300 hover:translate-y-[-2px] shadow-sm">
                                    <h3 class="text-base font-semibold group-hover/item:text-[#ffeb00] transition-colors duration-200 mb-2">{{ notification.title }}</h3>
                                    <div class="flex gap-2 items-center text-white/60 text-xs">
                                        <CalendarDays class="size-4" />
                                        {{
                                            new Date(notification.created_at).toLocaleString('en-CA', {
                                                year: 'numeric',
                                                month: 'short',
                                                day: '2-digit',
                                            })
                                        }}
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center items-center mt-6 pt-4 border-t border-white/10">
                        <Link href="/notifications" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/20 rounded-xl px-5 py-2.5 font-bold transition-all duration-300 text-sm hover:scale-105">
                            <span>View All Notifications</span>
                            <ArrowBigRight class="size-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>