<script setup lang="ts">
import { NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from './AppLogoIcon.vue';
import { MapPin, Phone, Mail } from 'lucide-vue-next';

// Quick navigation items
const QuickLinksItems: NavItem[] = [
    {
        title: 'Online Registration',
        href: '/online-registration',
    },
    {
        title: 'School Magazine',
        href: '/magazine',
    },
    {
        title: 'News & Events',
        href: '/news-events',
    },
    {
        title: 'About Us',
        href: '/about',
    },
    // {
    //     title: 'Activities',
    //     href: '/activities',
    // },
    {
        title: 'Faculty',
        href: '/faculty',
    },
    {
        title: 'Staff',
        href: '/staff',
    },
];

// Information navigation items
const InformationItems: NavItem[] = [
    {
        title: 'Rules and Regulations',
        href: '/rules-regulations',
    },
    {
        title: 'Transfer Certificate',
        href: '/transfer-certificate',
    },
    {
        title: 'Notifications',
        href: '/notifications',
    },
    {
        title: 'Fees Structure',
        href: '/fees-structure',
    },
    {
        title: 'Results',
        href: '/results',
    },
    {
        title: 'Career',
        href: '/career',
    },
];

// Address navigation items
const AddressItems: NavItem[] = [
    {
        title: 'Nefabari, Rowriah, Jorhat - 785005 (ASSAM)',
        href: 'https://maps.app.goo.gl/ToS7tiRbAbFB8qrP7',
        icon: MapPin,
    },
    {
        title: 'Phone: 9395642231',
        href: 'tel:+919395642231',
        icon: Phone,
    },
    {
        title: 'Email: arnsjorhat@ymail.com',
        href: 'mailto:arnsjorhat@ymail.com',
        icon: Mail,
    },
];

</script>

<template>
    <div class="footer">
        <!-- <div class="bg-[#182333] px-8 py-20"> -->
        <!-- <div class="bg-[var(--primary-brand-500)] px-8 py-20"> -->
        <div class="bg-neutral-100 px-8 py-20">
            <div class="flex-col justify-center max-w-7xl mx-auto">
                <div class="flex gap-5">
                    <div class="size-20">
                        <AppLogoIcon />
                    </div>
                    <div class="my-auto">
                        <h5 class="">Assam Rifles Public School</h5>
                        <span class="font-semibold">
                            Jorhat Established in 1977, affiliated to CBSE.
                        </span>
                    </div>
                </div>
                <p class="mt-5">
                    Offering quality education guided by a dedicated team of trained educators.
                </p>
                <hr class="border-black/20 my-10">
            </div>


            <div
                class="footer-top grid text-left grid-cols-2 md:grid-cols-3 text-gray-700 small font-medium gap-x-8 gap-y-8 max-w-7xl mx-auto">
                <div class="flex flex-col items-start">
                    <h4 class="text-black mb-3">Quick Links</h4>
                    <Link
                        class="pb-1 small relative after:bg-gray-300 after:absolute after:h-[1.5px] after:w-0 after:bottom-0 after:left-0 hover:after:w-full after:transition-all after:duration-300 cursor-pointer w-fit"
                        v-for="item in QuickLinksItems" :key="item.title" :href="item.href">{{ item.title }}</Link>
                </div>
                <div class="flex flex-col items-start">
                    <h4 class="text-black mb-3">Information</h4>
                    <Link
                        class="pb-1 small relative after:bg-gray-300 after:absolute after:h-[1.5px] after:w-0 after:bottom-0 after:left-0 hover:after:w-full after:transition-all after:duration-300 cursor-pointer w-fit"
                        v-for="item in InformationItems" :key="item.title" :href="item.href">{{ item.title }}</Link>
                </div>
                <div class="flex flex-col items-start">
                    <h4 class="text-black mb-3">Address</h4>
                    <a target="_blank" rel="noopener noreferrer"
                        class="pb-1 small relative after:bg-gray-300 after:absolute after:h-[2px] after:w-0 after:bottom-0 after:left-0 hover:after:w-full after:transition-all after:duration-300 cursor-pointer w-fit"
                        v-for="item in AddressItems" :key="item.title" :href="item.href">
                        <span class="flex items-center">
                            <component :is="item.icon" class="size-4 mr-2" />
                            {{ item.title }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- <div class="bg-[#021526] p-8"> -->
        <div class="bg-[#3d5cd8] p-8">
        <div
                class="footer-bottom grid grid-cols-1 md:grid-cols-2 text-white small gap-y-8 max-w-7xl mx-auto">
                <div class="flex flex-col items-center text-center md:items-start">
                    <span class="text-gray-300">©2025 ARPS, Jorhat, All Rights Reserved.</span>
                    <a href="https://www.deolang.com/" target="_blank" class="text-sky-100 hover:text-white font-semibold">Powered by
                        DeoLang</a>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <!-- <span class="text-right text-gray-500">Today's visitors: 17</span> -->
                    <!-- <span class="text-right text-gray-500">Total visitors : 1,188</span> -->
                </div>
            </div>
        </div>
    </div>
</template>
