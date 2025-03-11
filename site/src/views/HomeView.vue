<template>
  <MainContent :title="$t('page.home')">
    <PageTitle :title="$t('page.latest_topics')" />
    <CommonList
      :items="topics"
      :is-end="isLastPage"
      :loading="topicsLoading"
      :error="topicsError"
      @retry="send"
    >
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
  </MainContent>
</template>

<script setup lang="ts">
import TopicItem from '@/components/TopicItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import CommonList from '@/components/CommonList.vue'
import { getAllTopics } from '@/services'
import { usePagination } from 'alova/client'

let lastItemId = 0

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  error: topicsError,
  send,
} = usePagination((page, limit) => getAllTopics(lastItemId, limit), {
  append: true,
  initialPageSize: 10,
}).onSuccess(() => {
  const items = topics.value
  if (!items) {
    return
  }

  lastItemId = items[items.length - 1].id
})
</script>
