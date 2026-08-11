<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import abhigya from '@/pages/AcademicAchievements/abhigya.avif';
import img1 from '@/pages/AcademicAchievements/img1.avif';
import img2 from '@/pages/AcademicAchievements/img2.avif';
import tahmina from '@/pages/AcademicAchievements/tahmina.avif';
import img3 from '@/pages/AcademicAchievements/img3.avif';
import img4 from '@/pages/AcademicAchievements/img4.avif';
import { ref, onMounted } from 'vue';

const moduleData = ref<any>(null);
const isLoading = ref(true);

onMounted(async () => {
    try {
        const response = await fetch('/api/modules/academic_achievements');
        const data = await response.json();
        moduleData.value = data;
    } catch (e) {
        console.error(e);
    } finally {
        isLoading.value = false;
    }
});

const images = [
  { src: abhigya, type: 'contain' },
  { src: img1, type: 'cover' },
  { src: img2, type: 'cover' },
  { src: tahmina, type: 'contain' },
  { src: img3, type: 'cover' },
  { src: img4, type: 'cover' },
];

</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Academic Achievements" />
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
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
                    <div v-for="(image, index) in images" class="aspect-4/3" :key="index">
                        <img 
                            :src="image.src" 
                            alt="Academic achiever" 
                            class="h-full w-full rounded-xs"
                            :class="image.type === 'contain' ? 'object-contain bg-gray-50' : 'object-cover'"
                        >
                    </div>
                </div>


                <div v-if="isLoading" class="text-center py-10 text-gray-500 animate-pulse mt-10">Loading documents...</div>
                <div v-else-if="moduleData && moduleData.files && moduleData.files.length > 0" class="mt-10 space-y-12">
                    <div v-for="(file, index) in moduleData.files" :key="index">
                        <h3 class="text-xl font-bold text-gray-800 mb-4" v-if="moduleData.files.length > 1">{{ file.name }}</h3>
                        
                        <!-- PDF -->
                        <div v-if="file.type === 'pdf'" class="w-full h-[calc(100vh-200px)] rounded-xl overflow-hidden border shadow-sm bg-white">
                            <iframe :src="file.url" class="w-full h-full border-0"></iframe>
                        </div>
                        
                        <!-- Image -->
                        <div v-else-if="file.type === 'image'" class="w-full rounded-xl overflow-hidden border shadow-sm bg-white">
                            <img :src="file.url" class="w-full h-auto object-contain" />
                        </div>
                        
                        <!-- Video -->
                        <div v-else-if="file.type === 'video'" class="w-full rounded-xl overflow-hidden border shadow-sm bg-black flex justify-center items-center">
                            <video :src="file.url" controls class="w-full h-auto max-h-[85vh]"></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
