<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <RouterLink to="/" class="mob-show">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicList :topics="topics" />
  <InfiniteScroll :disabled="noMore || isFailed" @loadmore="getTopic" />
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
    <NH5 v-if="noMore" class="text-center" :align-text="true">没有更多了</NH5>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText, NSpin, NH5, NButton } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { ref } from 'vue'
import { useFetchData } from '@/utils/useFetchData'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const topics = ref<Topic[]>([])
const limit = 10
let last = 0
const { isFailed, isLoading, noMore, fetch, retry } = useFetchData<Topic[]>(
  getTopicList,
  (data) => {
    if (data.length < limit) {
      noMore.value = true
    }
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
