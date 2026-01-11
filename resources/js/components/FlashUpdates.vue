<script setup lang="ts">
    import { ref } from 'vue'
    
    const isVisible = ref<boolean>(true)
    </script>
    
    <template>
      <div 
        v-if="isVisible" 
        class="fixed inset-0 z-50 backdrop-blur-xs backdrop-grayscale-75 w-full h-full"
        @click.self="isVisible = false"
      >
        <!-- Modal content - doesn't close on backdrop click -->
        <div class="p-10 flex justify-center items-center min-h-screen">
          <div class="relative max-w-[700px] w-[90%] mx-auto">
            <!-- Close button -->
            <button
              class="absolute -top-12 -right-4 w-12 h-12 bg-white/90 hover:bg-white rounded-full flex items-center justify-center text-gray-800 text-xl font-bold shadow-lg hover:scale-110 transition-all duration-200 z-10"
              @click="isVisible = false"
              aria-label="Close modal"
            >
              ×
            </button>
            
            <!-- Image -->
            <img 
              src="@/../../resources/images/admission_flash.webp" 
              class="w-full h-auto rounded-lg shadow-2xl"
              alt="Admission flash banner"
            />
          </div>
        </div>
      </div>
    </template>
    