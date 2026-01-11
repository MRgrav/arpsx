<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Hero from '@/components/Home/Hero.vue';
import AboutAndNotification from '@/components/Home/AboutAndNotification.vue';
import MessageCard from '@/components/Home/MessageCard.vue';
import NewsAndEvents from '@/components/Home/NewsAndEvents.vue';
import Stats from '@/components/Home/Stats.vue';
import Activities from '@/components/Home/Activities.vue';
import { Post, Profile } from '@/types';
import OurSchoolFamily from '@/components/Home/OurSchoolFamily.vue';
import FlashUpdates from '@/components/FlashUpdates.vue';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
  notifications: Notification[]
  profiles: Profile[]
  posts: Post[]
}
const props = defineProps<Props>() // Make props reactive and type-safe.

</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <meta property="og:title" content="Assam Rifles Public School, Jorhat | Jorhat ">
        <meta property="og:description" content="Assam Rifles Public School, Jorhat, Jorhat. KNOWLEDGE IS WORSHIP">
    </Head>
    <AppLayout class="overflow-hidden">
        <FlashUpdates />
        <Hero />
        <AboutAndNotification :notifications="props.notifications"/>
        <MessageCard :profiles="props.profiles"/>
        <NewsAndEvents :posts="props.posts"/>
        <Stats/>
        <Activities/>
        <OurSchoolFamily/>
    </AppLayout>
</template>
