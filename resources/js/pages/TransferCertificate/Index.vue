<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import { Button } from '@/components/ui/button';
import { ref, onMounted } from 'vue';

const moduleData = ref<any>(null);
const isLoading = ref(true);

onMounted(async () => {
    try {
        const response = await fetch('/api/modules/transfer_certificate');
        const data = await response.json();
        moduleData.value = data;
    } catch (e) {
        console.error(e);
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Transfer Certificate" />
        <div class="p-8 lg:p-16" data-ast-blocks-layout="true" itemprop="text">
            <div class="py-2 space-y-4">
                <p>
                    Transfer Certificate documents and information are provided below.
                </p>
            </div>
            
            <div v-if="isLoading" class="text-center py-10 text-gray-500 animate-pulse">Loading documents...</div>
            <div v-else-if="!moduleData || !moduleData.files || moduleData.files.length === 0" class="text-center py-10 text-gray-500">
                No documents available at the moment.
            </div>
            <div v-else class="mt-6 space-y-12">
                <div v-for="(file, index) in moduleData.files" :key="index">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800" v-if="moduleData.files.length > 1">{{ file.name }}</h3>
                        <a download target="_blank" :href="file.url" v-if="file.type === 'pdf'">
                            <Button class="bg-blue-600 hover:bg-blue-700">Download Form</Button>
                        </a>
                    </div>
                    
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
                    
                    <!-- Other -->
                    <div v-else class="p-6 bg-gray-50 border rounded-xl shadow-sm text-center">
                        <a :href="file.url" target="_blank" class="text-blue-600 font-medium hover:underline flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download {{ file.name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>