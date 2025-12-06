<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import abhigya from '@/pages/AcademicAchievements/abhigya.png';
import img1 from '@/pages/AcademicAchievements/img1.jpeg';
import img2 from '@/pages/AcademicAchievements/img2.jpeg';
import tahmina from '@/pages/AcademicAchievements/tahmina.png';
import img3 from '@/pages/AcademicAchievements/img3.jpeg';
import img4 from '@/pages/AcademicAchievements/img4.jpeg';
import topperPdf from '@/pages/AcademicAchievements/toppers.pdf';

import { VuePDF, usePDF } from '@tato30/vue-pdf'

const { pdf } = usePDF(topperPdf);
const images = [abhigya, img1, img2, tahmina, img3, img4];

</script>

<template>
    <AppLayout>
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="font-bold mb-4">Academic Achievements</h1>
                <p class=" mx-auto text-gray-500 leading-relaxed">
                    Celebrating Academic Excellence at ARPS Jorhat

                    Assam Rifles Public School, Jorhat, proudly congratulates our brilliant students for their
                    outstanding academic achievements in the recent board examinations.

                    This year, Tahmina Anjum and Abhigya Koushik have brought great pride to the institution by securing
                    the highest marks in their respective streams, emerging as the School Toppers. Their relentless
                    dedication and hard work were honoured in a special ceremony where they were felicitated by Sri
                    Gaurav Gogoi, Honourable Member of Parliament.

                    We also extend our heartfelt congratulations to Anindita Saikia of Class XII Humanities for her
                    commendable performance. She was felicitated by Sri Gaurav Gogoi and Sri Bhaskar Jyoti Baruah,
                    Honourable MLA of Titabar, in recognition of her academic excellence.

                    The school community stands proud of these students and looks forward to their continued success in
                    the future. Their achievements are a testament to the spirit of perseverance and the high standard
                    of education at ARPS Jorhat.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 py-10 mb-20">
                    <div v-for="image in images" class="aspect-4/3" :key="image">
                        <img :src="image" alt="" class="h-full w-full"
                            :class="image.includes('.png') ? 'object-contain' : 'object-cover'">
                    </div>
                </div>

                <VuePDF v-for="pageNo in 1" :pdf="pdf" fit-parent :page="pageNo" :key="pageNo" />
            </div>
        </div>
    </AppLayout>
</template>
