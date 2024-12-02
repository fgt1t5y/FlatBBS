<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    disable-panels
    @retry="loadBoardInfo"
  >
    <PageTitle title="发话题">
      <template #extra>
        <button
          :disabled="topicPublishing"
          class="btn btn-primary btn-md w-full"
          @click="checkForm() && handlePublishTopic()"
        >
          发布
        </button>
      </template>
    </PageTitle>
    <div class="p-3 flex flex-col">
      <input
        v-model="topicDraft.title"
        class="text-lg"
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
import { useWatcher, useRequest } from 'alova/client'
import { getBoardInfo, publishTopic } from '@/services'
import { computed, onActivated, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useTitle } from '@/utils'
import router from '@/router'
import { useMessage } from '@/stores'

const route = useRoute()
const ms = useMessage()
const { setTitle } = useTitle('发布')
const currentSlug = computed(() => route.params.slug as string)
const topicDraft = ref({
  title: '',
  content: '',
})

const checkForm = () => {
  if (!topicDraft.value.title.trim()) {
    ms.error('请填写标题')
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
  middleware(_, next) {
    if (currentSlug.value) {
      next()
    }
  },
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
      boardInfo.value.data.id,
    ),
  {
    immediate: false,
  },
)

onBoardInfoSuccess(() => {
  setTitle(boardInfo.value.data.name)
})

onTopicPulished(() => {
  ms.success('发布成功')
  router.replace(`/topic/${topic.value.id}`)
})

onActivated(() => {
  loadBoardInfo()
})
</script>
