<template>
  <PageTitle :title="current" />
  <TopicEditor ref="topicEditorRef" />
  <TopicList :topics="topics" />
  <InfiniteScroll :disabled="noMore || isFailed" @loadmore="getTopic" />
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
    <NText v-if="noMore" class="text-center">没有更多了</NText>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NSpin, NButton, NText } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchData, useTitle } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'

const topics = ref<Topic[]>([])
const route = useRoute()
const { setTitle, current } = useTitle('版块')
const currentBoardId = computed(() => {
  const boardId = Number(route.params.board_id ?? '0')
  if (boardId !== 0) {
    setTitle(route.params.name as string)
  }

  return boardId
})
let lastBoardId = currentBoardId.value
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
  fetch(last, limit, currentBoardId.value)
}
const refresh = () => {
  if (!currentBoardId.value) return
  topics.value = []
  last = 0
  noMore.value = false
  getTopic()
}

watch(
  () => currentBoardId.value,
  (to) => {
    if (!to || to === lastBoardId) return
    lastBoardId = to
    refresh()
  },
)
</script>
