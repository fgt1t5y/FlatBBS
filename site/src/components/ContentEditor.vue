<template>
  <div class="content-editor">
    <NTabs
      type="bar"
      size="small"
      :tabs-padding="12"
      @update:value="onTabChange"
    >
      <NTabPane name="edit" tab="编辑">
        <NInput
          v-model:value="content"
          type="textarea"
          size="large"
          :autosize="{ minRows: 3 }"
          :placeholder="placeholder"
          @change="onTextareaInput"
        />
      </NTabPane>
      <NTabPane name="preview" tab="预览">
        <NAlert type="info">发布前请查看预览效果</NAlert>
        <div class="topic-content" v-html="previewContent"></div>
      </NTabPane>
    </NTabs>
  </div>
</template>

<script setup lang="ts">
import { resolveRichContent } from '@/utils'
import { NAlert, NInput, NTabPane, NTabs } from 'naive-ui'
import { ref } from 'vue'

defineOptions({
  name: 'ContentEditor',
})

interface ContentEditorProps {
  placeholder?: string
  maxLength?: number
}

const props = withDefaults(defineProps<ContentEditorProps>(), {
  placeholder: '',
  maxLength: 4000,
})
const emits = defineEmits<{
  (e: 'update:value', v: string): void
}>()
const content = ref<string>('')
const previewContent = ref<string>('')
const getPreview = async () => {
  previewContent.value = await resolveRichContent(content.value)
}
const onTabChange = (value: string) => {
  if (value === 'preview') {
    getPreview()
  }
}
const onTextareaInput = (value: string) => {
  emits('update:value', value)
}
</script>
