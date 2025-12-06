<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
  <AppLayout>
    <div class="p-8 lg:p-16">
      <!-- Title and Introduction -->
      <div class="text-center">
        <h1 class="text-4xl font-bold">
          <span class="text-yellow-600">SUBHASH</span> <span class="text-gray-800">HOUSE</span>
        </h1>
        <p class="mt-4 italic text-yellow-700 max-w-3xl mx-auto">
          Subhash House, named after the great Indian freedom fighter Netaji Subhash Chandra Bose. Subhash
          House embodies the values of courage, resilience, and determination. House promotes teamwork,
          friendship, and healthy competition among students.
        </p>
      </div>

      <!-- Divider -->
      <div class="flex justify-center my-6 text-3xl">
        ❄️
      </div>

      <!-- Our House Strives For -->
      <div class="mt-10">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Our house strives for:</h2>
        <ul class="list-decimal list-inside text-gray-800 space-y-1">
          <li>Team spirit and unity</li>
          <li>Excellence in extracurricular activities</li>
          <li>Leadership and innovation</li>
          <li>Pride and loyalty to our house</li>
          <li>Develop leadership skills</li>
          <li>Showcase talents and creativity</li>
          <li>Represent their house with pride</li>
        </ul>
      </div>

      <!-- Food Club -->
      <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Food Club</h2>
        <p class="text-gray-700 mb-2">The Food Club is a fun group where students can:</p>
        <ul class="list-decimal list-inside text-gray-800 space-y-1">
          <li>Share favorite recipes</li>
          <li>Learn about different cuisines</li>
          <li>Cook and taste new foods</li>
          <li>Make friends who love food!</li>
        </ul>
      </div>

      <!-- Dance Drama and Music Club -->
      <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Dance Drama and Music Club</h2>
        <p class="text-gray-700 mb-2">
          Provide a platform for students to express themselves through dance and music, promoting creativity,
          teamwork, and self-confidence.
        </p>
        <ul class="list-decimal list-inside text-gray-800 space-y-1">
          <li>Develops creativity and self-expression</li>
          <li>Enhances teamwork and communication skills</li>
          <li>Boosts confidence and stage presence</li>
          <li>Fosters appreciation for diverse art forms</li>
        </ul>
      </div>

      <!-- Teacher Members -->
      <div class="mt-10 mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Teacher Members</h2>
        <ul class="list-disc list-inside text-blue-800 space-y-2">
          <li><em>Mrs. Archana Dutta (Incharge)</em></li>
          <li><em>Mrs. Rita Borah Neog (Vice Incharge)</em></li>
          <li><em>Ms. Smriti Rekha Gayan (Incharge Music dance and Drama Club)</em></li>
          <li><em>Mrs. Manish Hazarika (Incharge Food Club)</em></li>
          <li><em>Mrs. Angeeta Sharma</em></li>
          <li><em>Mustafa Kamal</em></li>
          <li><em>Mr. Anjan Kr. Dutta</em></li>
          <li><em>Syeda Nuzba Begum</em></li>
        </ul>
        <div class=" py-10 px-4 md:px-20 hidden">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Subhash House Activities Gallery</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">
            <img src="https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png" alt="Subhash Activity 1"
              class="w-full h-auto rounded shadow">


          </div>
        </div>
      </div>
      <!-- Image Gallery -->


    </div>
  </AppLayout>
</template>