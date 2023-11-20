<template>
  <div class="topic-editor">
    <NInput
      v-model:value="draft.title"
      :maxlength="64"
      placeholder="话题标题..."
      show-count
    />
    <ContentEditor
      v-model:value="draft.content"
      placeholder="在此输入话题正文"
    />
    <div class="topic-editor-tool">
      <NButton type="primary" round @click="submit">发布</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicEditor.css'
import { NButton, NInput } from 'naive-ui'
import ContentEditor from './ContentEditor.vue'
import { useTopic } from '@/utils/useTopic'

defineOptions({
  name: 'TopicEditor',
})

const { draft, submit } = useTopic()
</script>
