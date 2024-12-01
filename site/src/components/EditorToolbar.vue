<template>
  <div
    :class="{
      'editor-toolbar': true,
      'editor-toolbar-float': isMobile,
    }"
  >
    <input
      ref="imageInput"
      type="file"
      name="avatar"
      accept=".jpg,.png,.jpeg"
      style="display: none"
      @change="uploadAndInsertImage"
    />
    <NButton
      v-for="(tool, index) in editorTools"
      :key="index"
      text
      size="large"
      :type="tool.isActive() ? 'primary' : 'default'"
      @click="tool.onClick"
    >
      <NIcon :size="24" :component="tool.icon" />
    </NButton>
  </div>
</template>

<script setup lang="ts">
import type { Editor } from '@tiptap/vue-3'
import { ref, type Component } from 'vue'
import { NButton, NIcon } from 'naive-ui'
import {
  H1,
  H2,
  Bold,
  Italic,
  List,
  ListNumbers,
  Quote,
  Photo,
  ArrowBackUp,
  ArrowForwardUp,
} from '@vicons/tabler'
import { isMobile } from '@/utils'
import { uploadFile } from '@/services'

defineOptions({
  name: 'EditorToolbar',
})

interface EditorToolbarProps {
  editor: Editor
}

interface EditorTools {
  name: string
  icon: Component
  onClick: any
  isActive: () => boolean
}

const props = defineProps<EditorToolbarProps>()
const imageInput = ref<HTMLInputElement>()

const uploadAndInsertImage = () => {
  if (!imageInput.value?.files?.length) {
    return
  }

  const image = imageInput.value.files[0]
  uploadFile(image).then((res) => {
    res.data.forEach((uri) => {
      props?.editor.commands.setImage({
        src: uri,
      })
    })
  })
}

const editorTools = [
  {
    name: 'heading-1',
    icon: H1,
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 1 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 1 }),
  },
  {
    name: 'heading-2',
    icon: H2,
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 2 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 2 }),
  },
  {
    name: 'bold',
    icon: Bold,
    onClick: () => props?.editor.chain().focus().toggleBold().run(),
    isActive: () => props?.editor.isActive('bold'),
  },
  {
    name: 'italic',
    icon: Italic,
    onClick: () => props?.editor.chain().focus().toggleItalic().run(),
    isActive: () => props?.editor.isActive('italic'),
  },
  {
    name: 'bullet-list',
    icon: List,
    onClick: () => props?.editor.chain().focus().toggleBulletList().run(),
    isActive: () => props?.editor.isActive('bulletList'),
  },
  {
    name: 'ordered-list',
    icon: ListNumbers,
    onClick: () => props?.editor.chain().focus().toggleOrderedList().run(),
    isActive: () => props?.editor.isActive('orderedList'),
  },
  {
    name: 'blockquote',
    icon: Quote,
    onClick: () => props?.editor.chain().focus().toggleBlockquote().run(),
    isActive: () => props?.editor.isActive('blockquote'),
  },
  {
    name: 'image',
    icon: Photo,
    onClick: () => imageInput.value!.click(),
    isActive: () => false,
  },
  {
    name: 'undo',
    icon: ArrowBackUp,
    onClick: () => props?.editor.chain().focus().undo().run(),
    isActive: () => false,
  },
  {
    name: 'redo',
    icon: ArrowForwardUp,
    onClick: () => props?.editor.chain().focus().redo().run(),
    isActive: () => false,
  },
] as EditorTools[]
</script>
