<template>
  <div class="editor">
    <EditorContent :editor="editor" />
  </div>
</template>

<script setup lang="ts">
import '@/style/RichEditor.css'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import { onBeforeUnmount } from 'vue'

const editor = useEditor({
  content: '',
  extensions: [
    StarterKit.configure({
      heading: {
        levels: [1, 2],
      },
    }),
    Placeholder.configure({
      placeholder: '点击输入内容',
    }),
  ],
})

onBeforeUnmount(() => {
  if (editor.value) {
    editor.value.destroy()
  }
})
</script>
