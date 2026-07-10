<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import coverImage from '@/pages/Laboratory/Physics/physics.avif';

</script>


<template>
    <AppLayout>
        <PageHeadIndi heading="Physics Lab" />
        <div class="p-8 lg:p-16 w-full" data-ast-blocks-layout="true" itemprop="text">
            <img :src="coverImage" alt="" class="w-full object-cover object-top">
            <p class="text-gray-700 pt-8">
                <span class="me-5"></span>Our Physics Lab is equipped with modern apparatus and instruments, enabling students to explore fundamental concepts through hands-on experimentation. From mechanics to electromagnetism, our lab facilitates experiential learning, fostering a deeper understanding of physical principles. Experienced faculty guide students in conducting experiments, analyzing data, and drawing meaningful conclusions.In experiments we have Meter bridge, Potentiometer, Travelling microscope, Vernier callipers, Screw gauge,Spherometer, Ohm’s law apparatus , Prism, Glass slab and p-n junction etc.</p>
        </div>
    </AppLayout>
</template>