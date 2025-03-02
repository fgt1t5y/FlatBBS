<template>
  <div
    :class="{
      'bg-content flex gap-2 z-30': true,
      'sticky top-navbar py-3': !isMobile,
      'fixed left-0 bottom-0 w-full overflow-scroll p-3': isMobile,
    }"
  >
    <input
      ref="imageInput"
      type="file"
      name="avatar"
      accept=".jpg,.png,.jpeg,.gif"
      style="display: none"
      @change="uploadAndInsertImage"
    />
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
      <component :is="tool.icon" class="size-6" />
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, type Component } from 'vue'
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
import { uploadImage } from '@/services'

import type { Editor } from '@tiptap/vue-3'

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
  enable: () => boolean
}

const props = defineProps<EditorToolbarProps>()
const imageInput = ref<HTMLInputElement>()

const uploadAndInsertImage = async () => {
  if (!imageInput.value?.files?.length) {
    return
  }

  const image = imageInput.value.files[0]
  const imageUri = await uploadImage(image)

  if (imageUri) {
    props?.editor.commands.setImage({
      src: imageUri,
    })
  }
}

const editorTools = [
  {
    name: 'heading_1',
    icon: H1,
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 1 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 1 }),
    enable: () => true,
  },
  {
    name: 'heading_2',
    icon: H2,
    onClick: () =>
      props?.editor.chain().focus().toggleHeading({ level: 2 }).run(),
    isActive: () => props?.editor.isActive('heading', { level: 2 }),
    enable: () => true,
  },
  {
    name: 'bold',
    icon: Bold,
    onClick: () => props?.editor.chain().focus().toggleBold().run(),
    isActive: () => props?.editor.isActive('bold'),
    enable: () => true,
  },
  {
    name: 'italic',
    icon: Italic,
    onClick: () => props?.editor.chain().focus().toggleItalic().run(),
    isActive: () => props?.editor.isActive('italic'),
    enable: () => true,
  },
  {
    name: 'bullet_list',
    icon: List,
    onClick: () => props?.editor.chain().focus().toggleBulletList().run(),
    isActive: () => props?.editor.isActive('bulletList'),
    enable: () => true,
  },
  {
    name: 'ordered_list',
    icon: ListNumbers,
    onClick: () => props?.editor.chain().focus().toggleOrderedList().run(),
    isActive: () => props?.editor.isActive('orderedList'),
    enable: () => true,
  },
  {
    name: 'blockquote',
    icon: Quote,
    onClick: () => props?.editor.chain().focus().toggleBlockquote().run(),
    isActive: () => props?.editor.isActive('blockquote'),
    enable: () => true,
  },
  {
    name: 'image',
    icon: Photo,
    onClick: () => imageInput.value!.click(),
    isActive: () => false,
    enable: () => true,
  },
  {
    name: 'undo',
    icon: ArrowBackUp,
    onClick: () => props?.editor.chain().focus().undo().run(),
    isActive: () => false,
    enable: () => props.editor.can().undo(),
  },
  {
    name: 'redo',
    icon: ArrowForwardUp,
    onClick: () => props?.editor.chain().focus().redo().run(),
    isActive: () => false,
    enable: () => props.editor.can().redo(),
  },
] as EditorTools[]
</script>
