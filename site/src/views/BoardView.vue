<template>
  <PageTitle :title="current" />
  <BoardDetail :board-id="currentBoardId" />
  <TopicList :topics="data" />
  <IntersectionObserver :disabled="!isSuccess" @reach="next" />
  <RequestPlaceholder
    :is-loading="isLoading"
    :is-failed="isFailed"
    :no-more="noMore"
    @retry="refetch"
  />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchList, useTitle } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'
import BoardDetail from '@/components/BoardDetail.vue'

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
const {
  isLoading,
  isSuccess,
  isFailed,
  data,
  noMore,
  fetch,
  next,
  restore,
  refetch,
} = useFetchList<Topic>(getTopicList)
fetch(currentBoardId.value)

watch(
  () => currentBoardId.value,
  (to) => {
    if (!to || to === lastBoardId) return
    lastBoardId = to
    restore()
    fetch(to)
  },
)
</script>
