<template>
  <MainContent>
    <TopicList :topics="data" />
    <IntersectionObserver :disabled="noMore || isFailed" @reach="next" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      :no-more="noMore"
      @retry="fetch"
    />
  </MainContent>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import MainContent from '@/components/MainContent.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { useFetchList } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<
  Topic[]
>(getTopicList, 0)
</script>
