<template>
  <div class="topic-editor">
    <NInput
      v-model:value="topicDraft.title"
      :minlength="minLength"
      :maxlength="64"
      placeholder="话题标题..."
      show-count
      clearable
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
          :disabled="disabledSubmitButton || isLoading"
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
import { createTopic } from '@/services'
import '@/style/TopicEditor.css'
import { useFetchData } from '@/utils/useFetchData'
import { NInput, NButton, type InputInst } from 'naive-ui'
import { SmileIcon, ImageIcon, ChevronUpIcon } from 'tdesign-icons-vue-next'
import { reactive, ref } from 'vue'

defineOptions({
  name: 'TopicEditor',
})

interface TopicEditorProps {
  boardId: number
}

const props = withDefaults(defineProps<TopicEditorProps>(), {
  boardId: 0,
})
const minLength = 5
const topicDraft = reactive({
  title: '',
  content: '',
})
const emits = defineEmits<{
  (e: 'success'): void
}>()
const mainInputRef = ref<InputInst>()
const disabledSubmitButton = ref<boolean>(true)
// 是否展开完整编辑器
const isShowFull = ref<boolean>(false)
const onTitleInputFocus = () => {
  isShowFull.value = true
}
const onTitleInputChange = () => {
  if (topicDraft.title.length >= minLength) {
    disabledSubmitButton.value = false
  } else {
    disabledSubmitButton.value = true
  }
}
const { isLoading, fetch } = useFetchData(createTopic, () => {
  emits('success')
  window.$message.success('话题已发布！')
  clear()
  isShowFull.value = false
})
const clear = () => {
  topicDraft.title = ''
  topicDraft.content = ''
}
const sumbitTopic = () => {
  fetch(topicDraft.title, topicDraft.content, props.boardId)
}
</script>
