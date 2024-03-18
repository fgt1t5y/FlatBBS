<template>
  <MainContent>
    <PageTitle title="发布" />
    <div>
      <EditorToolbar :editor="editorRef" />
      <Editor @created="onEditorCreated" />
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import Editor from '@/components/Editor.vue'
import EditorToolbar from '@/components/EditorToolbar.vue'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { shallowRef } from 'vue'
import type { IDomEditor } from '@wangeditor/editor'

const editorRef = shallowRef()
const onEditorCreated = (editor: IDomEditor) => {
  editorRef.value = editor
}
</script>
