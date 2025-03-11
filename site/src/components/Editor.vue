<template>
  <EditorToolbar v-if="editor && showToolbar" :editor="editor" />
  <EditorContent :editor="editor" />
</template>

<script setup lang="ts">
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import Link from '@tiptap/extension-link'
import { Image } from '@/third-party/editor-plugins/image'
import { onBeforeUnmount } from 'vue'
import EditorToolbar from './EditorToolbar.vue'
import { useI18n } from 'vue-i18n'

defineOptions({
  name: 'Editor',
})

interface EditorProps {
  showToolbar?: boolean
}

const props = defineProps<EditorProps>()

const htmlValue = defineModel<string>('html', { default: '<p></p>' })
const textValue = defineModel<string>('text', { default: '' })

const { t } = useI18n()
const editor = useEditor({
  content: '',
  extensions: [
    StarterKit.configure({
      heading: {
        levels: [1, 2],
      },
      history: {
        depth: 50,
      },
    }),
    Placeholder.configure({
      placeholder: t('editor.default_placeholder'),
    }),
    Link.configure({
      openOnClick: false,
    }),
    Image.configure(),
  ],
  onUpdate: ({ editor }) => {
    textValue.value = editor.getText()
    htmlValue.value = editor.getHTML()
  },
})

onBeforeUnmount(() => {
  if (editor.value) {
    editor.value.destroy()
  }
})

defineExpose({
  editor,
})
</script>
