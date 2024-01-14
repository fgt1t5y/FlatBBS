<template>
  <div ref="editorTargetRef" class="editor-target"></div>
</template>

<script setup lang="ts">
import { onMounted, ref, shallowRef, watch, toRaw } from 'vue'
import { createEditor } from '@wangeditor/editor'
import type {
  SlateDescendant,
  IEditorConfig,
  IDomEditor,
} from '@wangeditor/editor'
import '@/style/editor.css'

defineOptions({
  name: 'Editor',
})

interface EditorProps {
  mode?: string
  defaultContent?: SlateDescendant[]
  defaultHTML?: string
  defaultConfig?: IEditorConfig
  modelValue?: string
  placeholder?: string
}

const props = withDefaults(defineProps<EditorProps>(), {
  mode: 'default',
  defaultContent: () => [],
  defaultHTML: '',
  defaultConfig: {} as any,
  modelValue: '',
  placeholder: '点击输入...',
})
const emits = defineEmits<{
  (e: 'created', ins: IDomEditor): void
  (e: 'change', ins: IDomEditor): void
  (e: 'destoryed', ins: IDomEditor): void
  (e: 'maxLength', ins: IDomEditor): void
  (e: 'focus', ins: IDomEditor): void
  (e: 'blur', ins: IDomEditor): void
  (e: 'update:modelValue', html: string): void
}>()
const editorTargetRef = ref<HTMLDivElement>()
const editorRef = shallowRef<IDomEditor>()
const currentValue = ref<string>('')
const initEditor = () => {
  if (!editorTargetRef.value) return

  const defaultContent = toRaw(props.defaultContent)

  createEditor({
    selector: editorTargetRef.value,
    mode: props.mode,
    content: defaultContent ?? [],
    html: props.defaultHTML || props.modelValue,
    config: {
      placeholder: props.placeholder,
      maxLength: 12000,
      onCreated(editor) {
        editorRef.value = editor
        emits('created', editor)
      },
      onChange(editor) {
        const editorHTML = editor.getHtml()

        currentValue.value = editorHTML
        emits('update:modelValue', editorHTML)
        emits('change', editor)
      },
      onDestroyed(editor) {
        emits('destoryed', editor)
      },
      onMaxLength(editor) {
        emits('maxLength', editor)
      },
      onFocus(editor) {
        emits('focus', editor)
      },
      onBlur(editor) {
        emits('blur', editor)
      },
    },
  })
}
const setEditorHTML = (newHTML: string) => {
  const editor = editorRef.value
  if (!editor) return

  editor.setHtml(newHTML)
}

onMounted(() => {
  initEditor()
})

watch(
  () => props.modelValue,
  (newValue: string) => {
    if (newValue === currentValue.value) return

    setEditorHTML(newValue)
  },
)
</script>
