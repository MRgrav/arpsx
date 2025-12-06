<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
  <AppLayout>
    <div class="p-8 lg:p-16">
      <!-- Header -->
      <div class="text-center">
        <h1 class="text-4xl font-bold">
          <span class="text-purple-600">NEHRU</span> <span class="text-gray-800">HOUSE</span>
        </h1>
        <p class="mt-4 italic text-gray-600 max-w-3xl mx-auto">
          Nehru House honors Pandit Jawaharlal Nehru, India’s first Prime Minister and a visionary in nation-building
          and education. Its purpose is to nurture curiosity, rational thinking, and democratic ideals. It encourages
          students to dream big, value learning, and contribute to societal progress.
        </p>
      </div>

      <!-- Divider Icon -->
      <div class="flex justify-center my-6 text-3xl">
        ❄️
      </div>

      <!-- Motto -->
      <div class="text-center mt-4">
        <h2 class="text-2xl font-semibold text-red-500">Moto</h2>
        <p class="text-xl font-bold mt-2 text-gray-800">Think Forward, Lead Progress</p>
        <p class="mt-2 italic text-gray-600 max-w-2xl mx-auto">
          This motto reflects Nehru’s commitment to modernization, education, and inclusive development—urging students
          to embrace learning and contribute to a better future.
        </p>
      </div>

      <!-- Values Section -->
      <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-800">Values:</h3>
        <p class="mt-2 text-gray-700">
          Nehru House upholds the values of knowledge, modernity, equality, and respect for democratic processes. It
          promotes critical thinking, open dialogue, and a scientific temper among its members.
        </p>
      </div>

      <!-- Activities Section -->
      <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800">Activities:</h3>
        <p class="mt-2 text-gray-700">
          Events include science exhibitions, innovation challenges, leadership summits, quizzes, and model UN sessions.
          Nehru House also emphasizes academic excellence, public speaking, and creative problem-solving.
        </p>
      </div>

      <!-- Leadership Section -->
      <div class="mt-6 mb-10">
        <h3 class="text-lg font-semibold text-gray-800">Leadership:</h3>
        <p class="mt-2 text-gray-700">
          Nehru House cultivates thoughtful and visionary leaders. Captains are chosen based on their intellectual
          curiosity, organizational skills, and ability to unite diverse opinions for common goals. Collaboration and
          strategic planning are key traits.
        </p>
      </div>
    </div>
  </AppLayout>

</template>
