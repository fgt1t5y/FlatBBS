<template>
  <div ref="toolbarTargetRef" class="toolbar-target"></div>
</template>

<script setup lang="ts">
import type { IDomEditor, IToolbarConfig } from '@wangeditor/editor'
import { DomEditor, createToolbar } from '@wangeditor/editor'
import { ref, watch } from 'vue'

defineOptions({
  name: 'EditorToolbar',
})

interface EditorToolbarProps {
  editor: IDomEditor
  mode?: string
  defaultConfig?: IToolbarConfig
}

const props = withDefaults(defineProps<EditorToolbarProps>(), {
  mode: 'default',
  defaultConfig: {} as any,
})
const toolbarTargetRef = ref<HTMLDivElement>()
const initToolbar = (editor: IDomEditor) => {
  if (!toolbarTargetRef.value || !editor) {
    console.log(toolbarTargetRef.value, editor)
    throw new Error('Target element or editor instance is null.')
  }
  if (DomEditor.getToolbar(editor)) return

  createToolbar({
    editor: editor,
    selector: toolbarTargetRef.value,
    mode: props.mode,
    config: {},
  })
}

watch(
  () => props.editor,
  (editor) => {
    if (!editor) return

    initToolbar(editor)
  },
)
</script>
