<template>
  <div ref="wrapper" class="editor"></div>
</template>

<script setup lang="ts">
import { mentionPlugin } from '@/utils/mentionPlugin'
import { Editor, type EditorProps } from 'bytemd'
import zh_Hans from 'bytemd/locales/zh_Hans.json'
import { ref, onMounted, watch } from 'vue'

defineOptions({
  name: 'Editor',
})

const wrapper = ref<HTMLElement>()
const editor = ref<Editor | undefined>(undefined)
const emits = defineEmits<{
  (e: 'update:value', v: string): void
}>()
const props = withDefaults(defineProps<EditorProps>(), {
  value: '',
  sanitize: undefined,
  plugins: () => [mentionPlugin()],
  mode: 'auto',
  locale: () => zh_Hans,
  placeholder: '',
  maxLength: 2048,
  editorConfig: () => {
    return {
      autofocus: false,
    }
  },
})

onMounted(() => {
  // @ts-expect-error No type file
  editor.value = new Editor({
    target: wrapper.value,
    props,
  })

  // @ts-expect-error No type file
  editor.value.$on('change', (ev: CustomEvent<{ value: string }>) => {
    emits('update:value', ev.detail.value)
  })
})

watch(
  () => props,
  (newValue) => {
    // @ts-expect-error No type file
    editor.value?.$set(newValue)
  },
  { deep: true },
)

defineExpose(wrapper.value)
</script>
