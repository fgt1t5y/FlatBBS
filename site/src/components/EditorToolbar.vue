<template>
  <div class="editor-toolbar">
    <button
      v-for="(tool, index) in editorTools"
      :key="index"
      :disabled="!tool.enable()"
      :class="{
        'btn-text': true,
        'btn-text-active': tool.isActive(),
      }"
      :title="$t(`editor.tool.${tool.name}`)"
      @click="tool.onClick"
    >
      <i :class="tool.icon"></i>
    </button>
  </div>
</template>

<script setup lang="ts">
import type { Editor } from '@tiptap/vue-3'

defineOptions({
  name: 'EditorToolbar',
})

interface EditorToolbarProps {
  editor: Editor
}

interface EditorTools {
  name: string
  icon: string
  onClick: any
  isActive: () => boolean
  enable: () => boolean
}

const props = defineProps<EditorToolbarProps>()

const editorTools = [
  {
    name: 'heading_1',
    icon: 'ti ti-h-1',
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 1 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 1 }),
    enable: () => true,
  },
  {
    name: 'heading_2',
    icon: 'ti ti-h-2',
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 2 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 2 }),
    enable: () => true,
  },
  {
    name: 'bold',
    icon: 'ti ti-bold',
    onClick: () => props?.editor.chain().focus().toggleBold().run(),
    isActive: () => props?.editor.isActive('bold'),
    enable: () => true,
  },
  {
    name: 'italic',
    icon: 'ti ti-italic',
    onClick: () => props?.editor.chain().focus().toggleItalic().run(),
    isActive: () => props?.editor.isActive('italic'),
    enable: () => true,
  },
  {
    name: 'bullet_list',
    icon: 'ti ti-list',
    onClick: () => props?.editor.chain().focus().toggleBulletList().run(),
    isActive: () => props?.editor.isActive('bulletList'),
    enable: () => true,
  },
  {
    name: 'ordered_list',
    icon: 'ti ti-list-numbers',
    onClick: () => props?.editor.chain().focus().toggleOrderedList().run(),
    isActive: () => props?.editor.isActive('orderedList'),
    enable: () => true,
  },
  {
    name: 'blockquote',
    icon: 'ti ti-blockquote',
    onClick: () => props?.editor.chain().focus().toggleBlockquote().run(),
    isActive: () => props?.editor.isActive('blockquote'),
    enable: () => true,
  },
  // {
  //   name: 'image',
  //   icon: 'ti ti-h-1',
  //   onClick: () => imageInput.value!.click(),
  //   isActive: () => false,
  //   enable: () => true,
  // },
  {
    name: 'undo',
    icon: 'ti ti-arrow-back-up',
    onClick: () => props?.editor.chain().focus().undo().run(),
    isActive: () => false,
    enable: () => props.editor.can().undo(),
  },
  {
    name: 'redo',
    icon: 'ti ti-arrow-forward-up',
    onClick: () => props?.editor.chain().focus().redo().run(),
    isActive: () => false,
    enable: () => props.editor.can().redo(),
  },
] as EditorTools[]
</script>
