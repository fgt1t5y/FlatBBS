<template>
  <CommonList
    :items="topics"
    :is-end="isLastPage"
    :loading="topicsLoading"
    :error="topicsError"
    @retry="loadTopics"
  >
    <template #default="{ item }">
      <TopicItem :topic="item" />
    </template>
  </CommonList>
  <IntersectionObserver :disabled="isLastPage" @reach="loadTopics" />
</template>

<script setup lang="ts">
import CommonList from '@/components/CommonList.vue'
import TopicItem from '@/components/TopicItem.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { getLikedTopicsByUsername } from '@/services'
import { usePagination } from 'alova/client'
import { useRoute } from 'vue-router'

const route = useRoute()

const username = route.params.username as string

let lastItemId = 0

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  error: topicsError,
  send: loadTopics,
} = usePagination(
  (page, limit) => getLikedTopicsByUsername(lastItemId, limit, username),
  {
    append: true,
    initialPageSize: 10,
  },
).onSuccess(() => {
  const items = topics.value
  if (!items) {
    return
  }

  lastItemId = items[items.length - 1].id
})
</script>
