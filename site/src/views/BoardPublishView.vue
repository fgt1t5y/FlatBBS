<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    disable-panels
    @retry="loadBoardInfo"
  >
    <PageTitle title="发话题">
      <template #extra>
        <NButton
          type="primary"
          :disabled="topicPublishing"
          round
          @click="checkForm() && handlePublishTopic"
        >
          发布
        </NButton>
      </template>
    </PageTitle>
    <div class="chunk editor-view">
      <input
        v-model="topicDraft.title"
        class="f-l"
        placeholder="话题标题"
        autofocus
      />
      <TiptapEditor v-model:model-value="topicDraft.content" />
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import TiptapEditor from '@/components/TiptapEditor.vue'
import { NButton } from 'naive-ui'
import { useWatcher, useRequest } from 'alova'
import { getBoardInfo, publishTopic } from '@/services'
import { computed, onActivated, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useTitle } from '@/utils'
import '@/style/EditorView.css'
import router from '@/router'

const route = useRoute()
const { setTitle } = useTitle('发布')
const currentSlug = computed(() => route.params.slug as string)
const topicDraft = ref({
  title: '',
  content: '',
})

const checkForm = () => {
  if (!topicDraft.value.title.trim()) {
    window.$message.error('请填写标题')
    return false
  }
  return true
}

const {
  loading: boardInfoLoading,
  data: boardInfo,
  error: boardInfoError,
  onSuccess: onBoardInfoSuccess,
  send: loadBoardInfo,
} = useWatcher(() => getBoardInfo(currentSlug.value), [currentSlug], {
  immediate: true,
  sendable: () => currentSlug.value !== undefined,
})

const {
  loading: topicPublishing,
  data: topic,
  onSuccess: onTopicPulished,
  send: handlePublishTopic,
} = useRequest(
  () =>
    publishTopic(
      topicDraft.value.title,
      topicDraft.value.content,
      boardInfo.value.id,
    ),
  {
    immediate: false,
  },
)

onBoardInfoSuccess(() => {
  setTitle(boardInfo.value.name)
})

onTopicPulished(() => {
  window.$message.success('发布成功')
  router.replace(`/topic/${topic.value.id}`)
})

onActivated(() => {
  loadBoardInfo()
})
</script>
