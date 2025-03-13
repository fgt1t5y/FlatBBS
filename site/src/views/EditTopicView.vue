<template>
  <MainContent :loading="topicLoading" :error="topicError" @retry="loadTopic">
    <PageTitle :title="$t('page.edit_topic')">
      <template #extra>
        <button
          :disabled="topicEditing"
          class="btn-primary btn-md"
          @click="submitEdit"
        >
          {{ $t('action.save') }}
        </button>
      </template>
    </PageTitle>
    <div class="p-3 flex flex-col border-bt">
      <input
        v-model="topic.title"
        class="text-xl focus-visible:outline-0"
        :placeholder="$t('topic.title')"
        autofocus
      />
    </div>
    <div class="p-3 flex flex-col border-bt">
      <Editor
        v-model:text="topic.text"
        v-model:html="topic.content"
        show-toolbar
      />
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import Editor from '@/components/Editor.vue'
import { editTopic, getTopic } from '@/services'
import { useRequest } from 'alova/client'
import { useI18n } from 'vue-i18n'
import { useRoute, useRouter } from 'vue-router'
import { useTitle } from '@/utils'
import { useMessage } from '@/stores'
import { onActivated } from 'vue'

const route = useRoute()
const router = useRouter()
const ms = useMessage()
const { t } = useI18n()
const { setTitle } = useTitle(t('page.edit_topic'))

const topicId = Number(route.params.topicId)

const {
  loading: topicLoading,
  data: topic,
  error: topicError,
  send: loadTopic,
} = useRequest(() => getTopic(topicId)).onSuccess(() => {
  setTitle(topic.value?.title)
})

const {
  loading: topicEditing,
  data: editIsSuccessful,
  error: topicEditError,
  send: submitEdit,
} = useRequest(
  () =>
    editTopic(
      topic.value.title,
      topic.value.text,
      topic.value.content,
      topicId,
    ),
  { immediate: false },
).onSuccess(async () => {
  if (editIsSuccessful) {
    ms.success(t('message.edit_discussion_success'))
    await router.replace({ name: 'topic', params: { topicId: topic.value.id } })
    location.reload()
  } else {
    if (topicEditError.value?.message) {
      ms.error(topicEditError.value?.message)
    }
  }
})

onActivated(() => {
  if (topic.value?.title) {
    setTitle(topic.value?.title)
  }
})
</script>
