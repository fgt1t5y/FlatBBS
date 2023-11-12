<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <RouterLink to="/" class="mob-show">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicEditor
    v-if="route.params.id"
    :board-id="currentBoardId"
    @success="refreshTopicList"
  />
  <TopicList ref="topicListRef" :topics="topics" />
  <InfiniteScroll :disabled="noMore || isFailed" @loadmore="getTopic" />
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
    <NH5 v-if="noMore" class="text-center" :align-text="true">没有更多了</NH5>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText, NSpin, NH5, NButton } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchData } from '@/utils/useFetchData'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const route = useRoute()
const topicListRef = ref<InstanceType<typeof TopicList>>()
const refreshTopicList = () => {
  refresh()
}
const currentBoardId = computed(() => {
  return Number(route.params.id ?? '0')
})
const topics = ref<Topic[]>([])
const limit = 10
let last = 0
const noMore = ref<boolean>(false)
const { isFailed, isLoading, fetch, retry } =
  useFetchData<Topic[]>(getTopicList)
const getTopic = () => {
  if (noMore.value) return
  fetch(
    (data) => {
      if (data.length < limit) {
        noMore.value = true
      }
      topics.value?.push(...data)
      !noMore.value && (last = data[data.length - 1].id)
    },
    last,
    limit,
    currentBoardId.value,
  )
}
const refresh = () => {
  topics.value = []
  last = 0
  noMore.value = false
  getTopic()
}

watch(() => route.params.id, refresh)
</script>
