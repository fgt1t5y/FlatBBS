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
          class="btn-primary btn-md"
          @click="checkForm() && handlePublishTopic()"
        >
          {{ $t('action.publish') }}
        </button>
      </template>
    </PageTitle>
    <div class="p-3 flex flex-col border-bt">
      <input
        v-model="topicDraft.title"
        class="text-xl focus-visible:outline-0"
        :placeholder="$t('topic.title')"
        autofocus
      />
    </div>
    <div class="p-3 flex flex-col border-bt">
      <Editor
        v-model:text="topicDraft.text"
        v-model:html="topicDraft.content"
        show-toolbar
      />
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import Editor from '@/components/Editor.vue'
import { useRequest } from 'alova/client'
import { getBoardInfo, publishTopic } from '@/services'
import { onActivated, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTitle } from '@/utils'
import { useMessage } from '@/stores'
import { useI18n } from 'vue-i18n'

const route = useRoute()
const router = useRouter()
const ms = useMessage()
const { t } = useI18n()
const { setTitle } = useTitle(t('action.publish'))

const topicDraft = ref({
  title: '',
  text: '',
  content: '',
})

const slug = route.params.slug as string

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
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(slug)).onSuccess(() => {
  setTitle(boardInfo.value.name)
})

const {
  loading: topicPublishing,
  data: topic,
  send: handlePublishTopic,
} = useRequest(
  () =>
    publishTopic(
      topicDraft.value.title,
      topicDraft.value.text,
      topicDraft.value.content,
      boardInfo.value.id,
    ),
  {
    immediate: false,
  },
).onSuccess(() => {
  ms.success(t('message.publish_topic_success'))
  router.replace(`/topic/${topic.value.id}`)
})

onActivated(() => {
  if (boardInfo.value?.name) {
    setTitle(boardInfo.value.name)
  }
})
</script>
