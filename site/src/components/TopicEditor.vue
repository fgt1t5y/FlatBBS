<template>
  <div class="topic-editor">
    <RichTextarea placeholder="在此输入话题正文，支持 Markdown（选填）" />
    <NInput
      v-model:value="topicDraft.title"
      :maxlength="64"
      :disabled="disabled"
      placeholder="话题标题..."
      show-count
      @focus="onTitleInputFocus"
      @input="onTitleInputChange"
    />
    <NInput
      v-if="isShowFull"
      ref="mainInputRef"
      v-model:value="topicDraft.content"
      type="textarea"
      placeholder="在此输入话题正文，支持 Markdown（选填）"
      :rows="3"
    />
    <div v-if="isShowFull" class="topic-editor-opt">
      <div class="topic-editor-tool">
        <NButton
          title="收起编辑器"
          secondary
          circle
          @click="isShowFull = false"
        >
          <template #icon>
            <ChevronUpIcon size="18px" />
          </template>
        </NButton>
        <NButton title="插入 Emoji" secondary circle>
          <template #icon>
            <SmileIcon size="18px" />
          </template>
        </NButton>
        <NButton title="插入图片到文末" secondary circle>
          <template #icon>
            <ImageIcon size="18px" />
          </template>
        </NButton>
      </div>
      <div class="topic-editor-submit">
        <NButton
          title="发布话题"
          type="primary"
          :disabled="disabled || disabledSubmitButton"
          round
          @click="sumbitTopic"
        >
          发布
        </NButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicEditor.css'
import type { TopicDraft } from '@/types'
import { NInput, NButton, type InputInst } from 'naive-ui'
import { SmileIcon, ImageIcon, ChevronUpIcon } from 'tdesign-icons-vue-next'
import { reactive, ref } from 'vue'
import RichTextarea from './RichTextarea.vue'

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
const mainInputRef = ref<InputInst>()
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
}
const sumbitTopic = () => {
  !props.disabled && emits('submit', topicDraft)
}

defineExpose({ clear })
</script>
