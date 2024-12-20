<template>
  <MainContent :loading="topicLoading" :error="topicError" @retry="loadTopic">
    <PageTitle :title="topic.title" />
    <TopicDetail
      :topic="topic"
      :liked="isTopicLiked"
      :like-count="currentLikeCount"
      @like="likeOrUnlike"
    />
    <div class="p-3 border-bt text-base font-bold">
      {{ $t('discussion.count', { count: discussions.length }) }}
    </div>
    <CommonList :items="discussions">
      <template #default="{ item, index }">
        <DiscussionItem :discussion="item" :index="index" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="loadDiscissions" />
    <RequestPlaceholder
      :loading="loading"
      :error="error"
      @retry="loadDiscissions"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import CommonList from '@/components/CommonList.vue'
import DiscussionItem from '@/components/DiscussionItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions, getTopic, likeTopic } from '@/services'
import { useRoute } from 'vue-router'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { usePagination, useRequest } from 'alova/client'
import TopicDetail from '@/components/TopicDetail.vue'
import { useTitle } from '@/utils'
import { useI18n } from 'vue-i18n'
import { onActivated, ref } from 'vue'
import { useUserStore } from '@/stores'

const route = useRoute()
const user = useUserStore()
const isTopicLiked = ref<boolean>(false)
const currentLikeCount = ref<number>(0)
const topicId = Number(route.params.topic_id)
const { t } = useI18n()
const { setTitle } = useTitle(t('topic.topic'))

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
  loadDiscissions()

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
  send: loadDiscissions,
} = usePagination((page, limit) => getDiscussions(lastItemId, limit, topicId), {
  append: true,
  initialPageSize: 10,
  immediate: false,
}).onSuccess(() => {
  const items = discussions.value
  if (!items || !items.length) return

  lastItemId = items[items.length - 1].id
})

onActivated(() => {
  if (topic.value?.title) {
    setTitle(topic.value.title)
  }
})
</script>
