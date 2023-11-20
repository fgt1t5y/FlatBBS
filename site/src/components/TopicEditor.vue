<template>
  <div class="topic-editor">
    <NInput
      v-model:value="topicDraft.title"
      :maxlength="64"
      :disabled="disabled"
      placeholder="话题标题..."
      show-count
      @focus="onTitleInputFocus"
      @input="onTitleInputChange"
    />
    <ContentEditor
      v-if="isShowFull"
      v-model:value="topicDraft.content"
      placeholder="在此输入话题正文（选填）"
    />
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicEditor.css'
import type { TopicDraft } from '@/types'
import { NInput } from 'naive-ui'
import { reactive, ref } from 'vue'
import ContentEditor from './ContentEditor.vue'

defineOptions({
  name: 'TopicEditor',
})

interface TopicEditorProps {
  disabled?: boolean
}

const props = withDefaults(defineProps<TopicEditorProps>(), {
  disabled: false,
})
const minLength = 5
const topicDraft = reactive({
  title: '',
  content: '',
})
const emits = defineEmits<{
  (e: 'submit', v: TopicDraft): void
}>()
const disabledSubmitButton = ref<boolean>(true)
// 是否展开完整编辑器
const isShowFull = ref<boolean>(false)
const onTitleInputFocus = () => {
  isShowFull.value = true
}
const onTitleInputChange = (value: string) => {
  if (value.length >= minLength) {
    disabledSubmitButton.value = false
  } else {
    disabledSubmitButton.value = true
  }
}
const clear = () => {
  topicDraft.title = ''
  topicDraft.content = ''
  isShowFull.value = false
}
const sumbitTopic = () => {
  !props.disabled && emits('submit', topicDraft)
}

defineExpose({ clear })
</script>
