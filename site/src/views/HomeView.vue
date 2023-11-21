<template>
  <PageTitle title="全部话题">
    <RouterLink to="/">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicList :topics="topics" />
  <IntersectionObserver :disabled="noMore || isFailed" @reach="getTopic" />
  <RequestPlaceholder
    :is-loading="isLoading"
    :is-failed="isFailed"
    :no-more="noMore"
    @retry="retry"
  />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { ref } from 'vue'
import { useFetchData } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const topics = ref<Topic[]>([])
const limit = 10
let last = 0
const { isLoading, isFailed, noMore, fetch, retry } = useFetchData<Topic[]>(
  getTopicList,
  (data) => {
    topics.value?.push(...data)
    !noMore.value && (last = data[data.length - 1].id)
  },
  { limit: limit },
)
const getTopic = () => {
  if (noMore.value) return
  fetch(last, limit, 0)
}
</script>
