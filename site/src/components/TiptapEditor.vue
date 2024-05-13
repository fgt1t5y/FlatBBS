<template>
  <div class="editor">
    <EditorToolbar v-if="editor" :editor="editor" />
    <div v-else>加载中</div>
    <EditorContent :editor="editor" />
  </div>
</template>

<script setup lang="ts">
import '@/style/RichEditor.css'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import Link from '@tiptap/extension-link'
import { onBeforeUnmount } from 'vue'
import EditorToolbar from './EditorToolbar.vue'

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
    Link.configure({
      openOnClick: false,
    }),
  ],
})

onBeforeUnmount(() => {
  if (editor.value) {
    editor.value.destroy()
  }
})
</script>
