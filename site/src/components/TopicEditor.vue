<template>
  <div class="topic-editor">
    <NInput
      v-model:value="draft.title"
      type="textarea"
      size="large"
      :autosize="{ minRows: 1, maxRows: 2 }"
      :maxlength="64"
      :allow-input="trimChangeRow"
      placeholder="话题标题..."
      show-count
    />
    <ContentEditor
      v-model:value="draft.content"
      placeholder="在此输入话题正文"
    />
    <div class="topic-editor-tool"></div>
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicEditor.css'
import { NInput } from 'naive-ui'
import ContentEditor from './ContentEditor.vue'
import { useTopic } from '@/utils/useTopic'

defineOptions({
  name: 'TopicEditor',
})

const trimChangeRow = (value: string) => !value.includes('\n')
const { draft, submit, isLoading } = useTopic()
</script>
