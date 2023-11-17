<template>
  <div class="rich-textarea">
    <textarea
      ref="textareaRef"
      rows="5"
      :placeholder="placeholder"
      :maxlength="maxLength"
      @input="syncText"
      @scroll="syncScroll"
    ></textarea>
    <div
      ref="highlightLayerRef"
      class="rich-textarea-highlight"
      v-html="parsedDOMString"
    ></div>
  </div>
</template>

<script setup lang="ts">
import '@/style/RichTextarea.css'
import { resolveRichContent } from '@/utils'
import { ref } from 'vue'

defineOptions({
  name: 'RichTextarea',
})

interface RichTextareaProps {
  placeholder?: string
  maxLength?: number
}

const props = withDefaults(defineProps<RichTextareaProps>(), {
  placeholder: '',
  maxLength: 4000,
})
const emits = defineEmits<{
  (e: 'update:modelValue', v: string): void
}>()
const parsedDOMString = ref<string>('')
const highlightLayerRef = ref<HTMLDivElement>()
const textareaRef = ref<HTMLTextAreaElement>()
const syncText = () => {
  parsedDOMString.value = resolveRichContent(textareaRef.value?.value ?? '')
  emits('update:modelValue', textareaRef.value!.value)
}
const syncScroll = () => {
  const { scrollTop, scrollLeft } = textareaRef.value!
  highlightLayerRef.value!.style.setProperty(
    'transform',
    `translate(${-scrollLeft}px, ${-scrollTop}px`,
  )
}
</script>
