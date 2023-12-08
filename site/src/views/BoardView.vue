<template>
  <MainContent>
    <PageTitle title="版块" />
    <BoardDetail :board-id="currentBoardId" />
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
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchList, useTitle } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'
import BoardDetail from '@/components/BoardDetail.vue'

const route = useRoute()
const { setTitle } = useTitle('版块')
const currentBoardId = computed(() => {
  const boardId = Number(route.params.board_id ?? '0')
  if (boardId !== 0) {
    setTitle(route.params.name as string)
  }

  return boardId
})
let lastBoardId = currentBoardId.value
const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<Topic>(
  getTopicList,
  currentBoardId,
)

watch(
  () => currentBoardId.value,
  (to) => {
    if (!to || to === lastBoardId) return
    lastBoardId = to
    fetch(true)
  },
)
</script>
