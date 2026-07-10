<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import flash26 from '@/../../resources/images/flash26.avif'
import flash26_720 from '@/../../resources/images/flash26-720.avif'

interface FlashUpdateData {
  enabled: boolean;
  image: string;
  image_mobile?: string;
}

const props = defineProps<{
  flashUpdate?: FlashUpdateData;
}>();

const isVisible = ref<boolean>(true)
const isLoaded = ref<boolean>(false)
const delayPassed = ref<boolean>(false)

// Determine if we should show the popup
const shouldShow = computed(() => {
  if (!isVisible.value) return false;
  
  // If settings are defined, follow the enabled flag
  if (props.flashUpdate) {
    return props.flashUpdate.enabled && (!!props.flashUpdate.image || !!flash26);
  }
  return true; // default enabled
});

onMounted(() => {
  // Smoothly trigger the show phase after a 2.5 second delay
  setTimeout(() => {
    delayPassed.value = true;
  }, 8000);
});

// Compute the active images
const imageSrc = computed(() => {
  return props.flashUpdate?.image || flash26;
});

const imageSrcset = computed(() => {
  const desktop = props.flashUpdate?.image || flash26;
  const mobile = props.flashUpdate?.image_mobile || props.flashUpdate?.image || flash26_720;
  return `${mobile} 720w, ${desktop} 1024w`;
});
</script>

<template>
  <div 
    v-if="shouldShow" 
    class="fixed inset-0 z-50 backdrop-blur-xs w-full h-full transition-all duration-500 ease-out flex justify-center items-center p-10 min-h-screen"
    :class="(isLoaded && delayPassed) ? 'opacity-100 pointer-events-auto bg-black/50' : 'opacity-0 pointer-events-none bg-black/0'"
    @click.self="isVisible = false"
  >
    <div 
      class="relative max-w-[700px] w-[90%] mx-auto transition-all duration-500 ease-out transform"
      :class="(isLoaded && delayPassed) ? 'scale-100 translate-y-0 opacity-100' : 'scale-95 translate-y-32 opacity-0'"
    >
      <!-- Close button -->
      <button
        class="absolute -top-12 -right-4 w-10 h-10 bg-black/60 hover:bg-black/90 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg hover:scale-110 transition-all duration-200 z-10"
        @click="isVisible = false"
        aria-label="Close modal"
      >
        ×
      </button>
      
      <!-- Image -->
      <img 
        :src="imageSrc" 
        :srcset="imageSrcset"
        sizes="(max-width: 768px) 90vw, 700px"
        class="w-full h-auto rounded-2xl shadow-2xl border border-white/10"
        alt="Admission flash banner"
        @load="isLoaded = true"
      />
    </div>
  </div>
</template>