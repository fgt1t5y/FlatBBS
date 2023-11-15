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
const resolveDOMString = (value: string) => {
  return value
    .replace(/^(.*)$/gm, '<p>$1</p>')
    .replace(/@(.+?)(?=\s)/gm, '<span class="mention">@$1</span>')
}
const resolveDisplayDOMString = (value: string) => {
  return value
    .replace(/\n/gm, ' </br>')
    .replace(/@(.+?)(?=\s)/gm, '<span class="mention">@$1</span>')
}
const syncText = () => {
  parsedDOMString.value = resolveDisplayDOMString(
    textareaRef.value?.value ?? '',
  )
  emits('update:modelValue', parsedDOMString.value)
}
const syncScroll = () => {
  const { scrollTop, scrollLeft } = textareaRef.value!
  highlightLayerRef.value!.style.setProperty(
    'transform',
    `translate(${-scrollLeft}px, ${-scrollTop}px`,
  )
}
const getDOMString = () => resolveDOMString(textareaRef.value?.value ?? '')

defineExpose({ getDOMString })
</script>
