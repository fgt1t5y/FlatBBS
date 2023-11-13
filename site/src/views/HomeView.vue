<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <RouterLink to="/" class="mob-show">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicList :topics="topics" />
  <InfiniteScroll
    :disabled="t.noMore.value || t.isFailed.value"
    @loadmore="getTopic"
  />
  <div class="row-center">
    <NSpin v-if="t.isLoading.value" :size="32" />
    <NButton v-if="t.isFailed.value" type="primary" @click="t.retry">
      重试
    </NButton>
    <NText v-if="t.noMore.value" class="text-center">没有更多了</NText>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText, NSpin, NButton } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { ref } from 'vue'
import { useFetchData } from '@/utils/useFetchData'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const topics = ref<Topic[]>([])
const limit = 10
let last = 0
const t = useFetchData<Topic[]>(
  getTopicList,
  (data) => {
    topics.value?.push(...data)
    !t.noMore.value && (last = data[data.length - 1].id)
  },
  { limit: limit },
)
const getTopic = () => {
  if (t.noMore.value) return
  t.fetch(last, limit, 0)
}
</script>
