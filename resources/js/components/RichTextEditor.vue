<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import { watch, onBeforeUnmount } from 'vue';
import { 
  Bold, 
  Italic, 
  List, 
  ListOrdered, 
  Heading1, 
  Heading2, 
  Heading3, 
  Quote, 
  Undo, 
  Redo, 
  Link as LinkIcon,
  Unlink
} from 'lucide-vue-next';

const props = defineProps<{
  modelValue?: string;
  placeholder?: string;
}>();

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
  content: props.modelValue || '',
  extensions: [
    StarterKit,
    Link.configure({
      openOnClick: false,
      HTMLAttributes: {
        class: 'text-blue-600 dark:text-blue-400 underline hover:text-blue-800',
      },
    }),
  ],
  editorProps: {
    attributes: {
      class: 'prose dark:prose-invert max-w-none focus:outline-none min-h-[160px] p-4 text-gray-800 dark:text-gray-200',
    },
  },
  onUpdate: () => {
    emit('update:modelValue', editor.value?.getHTML() || '');
  },
});

watch(
  () => props.modelValue,
  (value) => {
    const isSame = editor.value?.getHTML() === value;
    if (!isSame && editor.value) {
      editor.value.commands.setContent(value || '', { emitUpdate: false });
    }
  }
);

onBeforeUnmount(() => {
  editor.value?.destroy();
});

const setLink = () => {
  const previousUrl = editor.value?.getAttributes('link').href;
  const url = window.prompt('URL', previousUrl);

  if (url === null) return;
  if (url === '') {
    editor.value?.chain().focus().extendMarkRange('link').unsetLink().run();
    return;
  }

  editor.value?.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};
</script>

<template>
  <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden bg-white dark:bg-gray-900 shadow-2xs">
    <!-- Toolbar -->
    <div v-if="editor" class="flex flex-wrap items-center gap-1 p-2 bg-gray-50/80 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
      
      <!-- Bold -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('bold') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Bold"
      >
        <Bold class="size-4" />
      </button>

      <!-- Italic -->
      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('italic') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Italic"
      >
        <Italic class="size-4" />
      </button>

      <div class="w-px h-5 bg-gray-300 dark:bg-gray-700 mx-1"></div>

      <!-- Heading 1 -->
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('heading', { level: 1 }) }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Heading 1"
      >
        <Heading1 class="size-4" />
      </button>

      <!-- Heading 2 -->
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('heading', { level: 2 }) }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Heading 2"
      >
        <Heading2 class="size-4" />
      </button>

      <!-- Heading 3 -->
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('heading', { level: 3 }) }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Heading 3"
      >
        <Heading3 class="size-4" />
      </button>

      <div class="w-px h-5 bg-gray-300 dark:bg-gray-700 mx-1"></div>

      <!-- Bullet List -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('bulletList') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Bullet List"
      >
        <List class="size-4" />
      </button>

      <!-- Numbered List -->
      <button
        type="button"
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('orderedList') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Numbered List"
      >
        <ListOrdered class="size-4" />
      </button>

      <!-- Quote -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBlockquote().run()"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('blockquote') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Quote"
      >
        <Quote class="size-4" />
      </button>

      <div class="w-px h-5 bg-gray-300 dark:bg-gray-700 mx-1"></div>

      <!-- Link -->
      <button
        type="button"
        @click="setLink"
        :class="{ 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-blue-400': editor.isActive('link') }"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition"
        title="Add Link"
      >
        <LinkIcon class="size-4" />
      </button>

      <button
        v-if="editor.isActive('link')"
        type="button"
        @click="editor.chain().focus().unsetLink().run()"
        class="p-2 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40 transition"
        title="Remove Link"
      >
        <Unlink class="size-4" />
      </button>

      <div class="w-px h-5 bg-gray-300 dark:bg-gray-700 mx-1"></div>

      <!-- Undo -->
      <button
        type="button"
        @click="editor.chain().focus().undo().run()"
        :disabled="!editor.can().undo()"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition disabled:opacity-30"
        title="Undo"
      >
        <Undo class="size-4" />
      </button>

      <!-- Redo -->
      <button
        type="button"
        @click="editor.chain().focus().redo().run()"
        :disabled="!editor.can().redo()"
        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700 transition disabled:opacity-30"
        title="Redo"
      >
        <Redo class="size-4" />
      </button>
    </div>

    <!-- Editor Body -->
    <EditorContent :editor="editor" />
  </div>
</template>
