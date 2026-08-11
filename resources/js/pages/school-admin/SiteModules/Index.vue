<script setup lang="ts">
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Site Modules', href: '/school-admin/site-modules' },
];

interface SiteModuleFile {
  url: string;
  name: string;
  type: string;
}

interface SiteModule {
  id: number;
  name: string;
  files: SiteModuleFile[] | null;
}

const props = defineProps<{
  modules: SiteModule[];
}>();

const form = useForm({
  name: '',
  files: [] as File[],          // used for create
  existing_files: [] as any[], // used for edit
  new_files: [] as File[],      // used for edit
});

const isCreating = ref(false);
const editId = ref<number | null>(null);

const handleFileChange = (e: any) => {
  if (editId.value) {
    form.new_files = Array.from(e.target.files);
  } else {
    form.files = Array.from(e.target.files);
  }
};

const removeExistingFile = (index: number) => {
  if (form.existing_files) {
    form.existing_files.splice(index, 1);
  }
};

const createNew = () => {
    editId.value = null;
    form.reset();
    isCreating.value = !isCreating.value;
};

const editModule = (mod: SiteModule) => {
  editId.value = mod.id;
  form.name = mod.name;
  form.existing_files = mod.files ? [...mod.files] : [];
  form.new_files = [];
  form.files = [];
  isCreating.value = true;
};

const submit = () => {
  if (editId.value) {
    form.post(`/school-admin/site-modules/${editId.value}`, {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
        form.reset();
        isCreating.value = false;
        editId.value = null;
      },
    });
  } else {
    form.post('/school-admin/site-modules', {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
        form.reset();
        isCreating.value = false;
      },
    });
  }
};
</script>

<template>
  <Head title="Site Modules" />

  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      
      <!-- Header & Create Action -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Site Modules</h1>
        <Button @click="createNew">{{ isCreating ? 'Cancel' : 'Add New Module' }}</Button>
      </div>

      <!-- Create / Edit Form -->
      <div v-if="isCreating" class="bg-white p-6 rounded shadow border mb-6">
        <h2 class="text-xl font-semibold mb-4">{{ editId ? 'Edit Module' : 'Create New Module' }}</h2>
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block font-medium mb-1">Module Name (Must be unique)</label>
            <Input v-model="form.name" type="text" class="w-full" placeholder="e.g., cbse_documents" required />
            <div v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</div>
          </div>
          
          <div v-if="editId && form.existing_files.length > 0">
            <label class="block font-medium mb-2">Existing Files (Click remove to delete)</label>
            <ul class="space-y-2 border p-3 rounded bg-gray-50 max-h-48 overflow-y-auto">
              <li v-for="(file, index) in form.existing_files" :key="index" class="flex justify-between items-center text-sm p-2 bg-white rounded border">
                <a :href="file.url" target="_blank" class="text-blue-600 hover:underline truncate mr-4">{{ file.name }}</a>
                <button type="button" @click="removeExistingFile(index)" class="text-red-500 font-bold px-2 py-1 hover:bg-red-50 rounded">Remove</button>
              </li>
            </ul>
          </div>

          <div>
            <label class="block font-medium mb-1">{{ editId ? 'Add New Files' : 'Files (Images, PDFs, Videos)' }}</label>
            <Input type="file" multiple @change="handleFileChange" class="w-full" />
            <div v-if="form.errors.files" class="text-sm text-red-500 mt-1">{{ form.errors.files }}</div>
            <div v-if="form.errors.new_files" class="text-sm text-red-500 mt-1">{{ form.errors.new_files }}</div>
          </div>

          <div class="pt-2 flex gap-2">
            <Button type="submit" :disabled="form.processing">
              {{ form.processing ? 'Saving...' : 'Save Module' }}
            </Button>
            <Button type="button" variant="outline" @click="isCreating = false">Cancel</Button>
          </div>
        </form>
      </div>

      <!-- Modules Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="module in props.modules" :key="module.id" class="bg-white rounded-lg shadow border flex flex-col">
          <div class="p-4 border-b flex justify-between items-center bg-gray-50 rounded-t-lg">
            <h3 class="font-bold text-lg text-gray-800">{{ module.name }}</h3>
            <button @click="editModule(module)" class="text-blue-500 hover:text-blue-700 text-sm font-medium border border-blue-500 px-3 py-1 rounded bg-white">Edit</button>
          </div>
          
          <div class="p-4 flex-1">
            <p class="text-sm text-gray-500 mb-3 font-medium">Uploaded Files: {{ module.files ? module.files.length : 0 }}</p>
            
            <ul v-if="module.files && module.files.length > 0" class="space-y-2 max-h-48 overflow-y-auto">
              <li v-for="(file, index) in module.files" :key="index" class="flex items-center text-sm p-2 bg-gray-100 rounded border">
                <span v-if="file.type === 'pdf'" class="mr-2 text-red-500 font-bold">PDF</span>
                <span v-else-if="file.type === 'image'" class="mr-2 text-blue-500 font-bold">IMG</span>
                <span v-else-if="file.type === 'video'" class="mr-2 text-green-500 font-bold">VID</span>
                <span v-else class="mr-2 text-gray-500 font-bold">FILE</span>
                <a :href="file.url" target="_blank" class="text-blue-600 hover:underline truncate" :title="file.name">
                  {{ file.name }}
                </a>
              </li>
            </ul>
            <div v-else class="text-sm text-gray-400 italic py-2">
              No files uploaded for this module.
            </div>
          </div>
        </div>
      </div>
      
      <!-- Empty State -->
      <div v-if="props.modules.length === 0" class="text-center py-12 text-gray-500 bg-white rounded-lg border border-dashed">
        <p>No site modules found. Create one to get started.</p>
      </div>

    </div>
  </SchoolAdminLayout>
</template>
