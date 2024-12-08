<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    :title="$t('page.publish_topic')"
    disable-panels
    @retry="loadBoardInfo"
  >
    <PageTitle :title="$t('page.publish_topic')">
      <template #extra>
        <button
          :disabled="topicPublishing"
          class="btn btn-primary btn-md w-full"
          @click="checkForm() && handlePublishTopic()"
        >
          {{ $t('action.publish') }}
        </button>
      </template>
    </PageTitle>
    <div class="p-3 flex flex-col">
      <input
        v-model="topicDraft.title"
        class="text-lg"
        :placeholder="$t('topic.title')"
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
import { useI18n } from 'vue-i18n'

const route = useRoute()
const ms = useMessage()
const { t } = useI18n()
const { setTitle } = useTitle(t('action.publish'))
const currentSlug = computed(() => route.params.slug as string)
const topicDraft = ref({
  title: '',
  content: '',
})

const checkForm = () => {
  if (!topicDraft.value.title.trim()) {
    ms.error(t('message.fill_topic_title'))
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
  ms.success(t('message.publish_topic_success'))
  router.replace(`/topic/${topic.value.id}`)
})

onActivated(() => {
  loadBoardInfo()
})
</script>
