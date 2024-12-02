<template>
  <MainContent
    :loading="topicLoading"
    :error="topicError"
    disable-panels
    @retry="loadTopic"
  >
    <PageTitle :title="topic.title" />
    <TopicDetail :topic="topic" />
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
import { getDiscussions, getTopic } from '@/services'
import { useRoute } from 'vue-router'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { usePagination, useRequest } from 'alova/client'
import TopicDetail from '@/components/TopicDetail.vue'

const route = useRoute()

const topicId = Number(route.params.topic_id)
let lastItemId = 0

const {
  loading: topicLoading,
  data: topic,
  error: topicError,
  send: loadTopic,
} = useRequest(() => getTopic(topicId)).onSuccess(() => {
  loadDiscissions()
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
</script>
