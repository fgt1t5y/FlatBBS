<template>
  <MainContent :loading="topicLoading" :error="topicError" @retry="loadTopic">
    <PageTitle :title="topic.title" />
    <TopicDetail
      :topic="topic"
      :liked="isTopicLiked"
      :like-count="currentLikeCount"
      @like="likeOrUnlike"
    />
    <div class="p-3 text-base font-bold">
      {{ $t('discussion.count', { count: topic.discussion_count }) }}
    </div>
    <CommonList :items="discussions" :is-end="isLastPage">
      <template #default="{ item, index }">
        <DiscussionItem :discussion="item" :index="index" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="loadDiscussions" />
    <RequestPlaceholder
      :loading="loading"
      :error="error"
      @retry="loadDiscussions"
    />
    <div v-if="topic" class="border-bt">
      <div class="p-3 text-base font-bold">
        {{ $t('discussion.publish') }}
      </div>
      <div v-if="user.isLogin" class="p-3 flex gap-2">
        <Avatar
          class="size-8 md:size-12"
          :src="user.info?.avatar_uri"
          rounded
        />
        <div class="grow">
          <TiptapEditor
            ref="discussionEditor"
            v-model:text="discussionEditorText"
            v-model:html="discussionEditorContent"
          />
        </div>
      </div>
      <div v-else>
        <div class="text-center text-muted">
          {{ $t('message.login_for_publish_discussion') }}
        </div>
      </div>
      <div v-if="discussionEditorText" class="p-3 flex justify-end">
        <button
          class="btn-primary btn-md"
          :disabled="discussionPublishing"
          @click="handlePublishDiscussion"
        >
          {{ $t('discussion.publish') }}
        </button>
      </div>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import CommonList from '@/components/CommonList.vue'
import DiscussionItem from '@/components/DiscussionItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import {
  getDiscussions,
  getTopic,
  likeTopic,
  publishDiscussion,
} from '@/services'
import { useRoute } from 'vue-router'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { usePagination, useRequest } from 'alova/client'
import TopicDetail from '@/components/TopicDetail.vue'
import { useTitle } from '@/utils'
import { useI18n } from 'vue-i18n'
import { onActivated, ref } from 'vue'
import { useMessage, useUserStore } from '@/stores'
import Avatar from '@/components/Avatar.vue'
import TiptapEditor from '@/components/TiptapEditor.vue'

const route = useRoute()
const user = useUserStore()
const ms = useMessage()
const isTopicLiked = ref<boolean>(false)
const currentLikeCount = ref<number>(0)
const discussionEditor = ref<InstanceType<typeof TiptapEditor>>()
const discussionEditorText = ref<string>('')
const discussionEditorContent = ref<string>('')
const { t } = useI18n()
const { setTitle } = useTitle(t('topic.topic'))

const topicId = Number(route.params.topic_id)

let lastItemId = 0

const { data: likeCount, send: likeOrUnlike } = useRequest(
  () => likeTopic(topicId),
  {
    immediate: false,
  },
).onSuccess(() => {
  isTopicLiked.value = !isTopicLiked.value

  currentLikeCount.value = likeCount.value
})

const {
  loading: topicLoading,
  data: topic,
  error: topicError,
  send: loadTopic,
} = useRequest(() => getTopic(topicId)).onSuccess(() => {
  setTitle(topic.value?.title)
  loadDiscussions()

  const likedUsers = topic.value.likes

  if (
    !likedUsers ||
    !user.isLogin ||
    !Array.isArray(likedUsers) ||
    !likedUsers.length
  ) {
    return false
  }

  isTopicLiked.value = likedUsers.some((like) => like.id === user.info?.id)
  currentLikeCount.value = topic.value.like_count
})

const {
  loading,
  data: discussions,
  isLastPage,
  error,
  send: loadDiscussions,
  insert: insertDiscussion,
} = usePagination((page, limit) => getDiscussions(lastItemId, limit, topicId), {
  append: true,
  initialPageSize: 10,
  immediate: false,
}).onSuccess(() => {
  const items = discussions.value
  if (!items || !items.length) {
    return
  }

  lastItemId = items[items.length - 1].id
})

const {
  loading: discussionPublishing,
  data: discussion,
  send: handlePublishDiscussion,
} = useRequest(
  () => publishDiscussion(discussionEditorContent.value, topicId),
  { immediate: false },
).onSuccess(() => {
  if (discussion.value) {
    insertDiscussion(discussion.value, lastItemId)
  }
  if (discussionEditor.value) {
    discussionEditor.value.editor?.commands.clearContent(true)
  }
  ms.success(t('message.publish_discussion_success'))
  topic.value.discussion_count++
})

onActivated(() => {
  if (topic.value?.title) {
    setTitle(topic.value.title)
  }
})
</script>
