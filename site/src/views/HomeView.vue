<template>
  <PageTitle title="全部话题">
    <RouterLink to="/">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
    <template #extra>
      <NButton v-if="!isDesktop" circle quaternary>
        <SearchIcon size="18px" />
      </NButton>
    </template>
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
import { NButton, NText } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { ref } from 'vue'
import { isDesktop, useFetchData } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'
import { SearchIcon } from 'tdesign-icons-vue-next'

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
