<script setup lang="ts">
import { ref } from 'vue'
import flash26 from '@/../../resources/images/flash26.avif'
import flash26_720 from '@/../../resources/images/flash26-720.avif'

const isVisible = ref<boolean>(true)
const isLoaded = ref<boolean>(false)
</script>

<template>
  <div 
    v-if="isVisible" 
    class="fixed inset-0 z-50 backdrop-blur-xs backdrop-grayscale-75 w-full h-full transition-all duration-300 flex justify-center items-center p-10 min-h-screen"
    :class="isLoaded ? 'opacity-100 pointer-events-auto bg-black/40' : 'opacity-0 pointer-events-none bg-black/0'"
    @click.self="isVisible = false"
  >
    <div class="relative max-w-[700px] w-[90%] mx-auto">
      <!-- Close button -->
      <button
        class="absolute -top-12 -right-4 w-12 h-12 bg-zinc-800/70 hover:bg-zinc-900/90 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg hover:scale-110 transition-all duration-200 z-10"
        @click="isVisible = false"
        aria-label="Close modal"
      >
        ×
      </button>
      
      <!-- Image -->
      <img 
        :src="flash26" 
        :srcset="`${flash26_720} 720w, ${flash26} 1024w`"
        sizes="(max-width: 768px) 90vw, 700px"
        class="w-full h-auto rounded-lg shadow-2xl transition-transform duration-500 ease-out"
        :class="isLoaded ? 'scale-100' : 'scale-95'"
        alt="Admission flash banner"
        @load="isLoaded = true"
      />
    </div>
  </div>
</template>


    