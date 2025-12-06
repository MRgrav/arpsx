<script setup lang="ts">
import PdfFile from '@/pages/tagore.pdf';
import AppLayout from '@/layouts/AppLayout.vue';
import { VuePDF, usePDF } from '@tato30/vue-pdf'

const { pdf } = usePDF(PdfFile);
</script>


<template>
    <AppLayout>
        <div class="p-8 lg:px-16" data-ast-blocks-layout="true" itemprop="text">
            <!-- <h1>Tagore House</h1> -->
           <div>
             <VuePDF v-for="pageNo in 22" :pdf="pdf" fit-parent :page="pageNo" :key="pageNo" class="mx-auto"/>
           </div>
        </div>
    </AppLayout>
</template>
