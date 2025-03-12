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
  <IntersectionObserver :disabled="isLastPage" @reach="nextPage" />
</template>

<script setup lang="ts">
import CommonList from '@/components/CommonList.vue'
import TopicItem from '@/components/TopicItem.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { getTopicsByUsername } from '@/services'
import { usePagination } from 'alova/client'
import { useRoute } from 'vue-router'

const route = useRoute()

const username = route.params.username as string

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  page,
  error: topicsError,
  send: loadTopics,
} = usePagination(
  (page, limit) => getTopicsByUsername(page, limit, username),
  {
    append: true,
    initialPageSize: 10,
  },
)

const nextPage = () => {
  page.value++
}
</script>
