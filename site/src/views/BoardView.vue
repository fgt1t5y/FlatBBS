<template>
  <MainContent>
    <PageTitle title="版块" />
    <BoardDetail :slug="currentSlug" />
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
import { getTopicsByBoardSlug } from '@/services'
import type { Topic } from '@/types'
import BoardDetail from '@/components/BoardDetail.vue'

const route = useRoute()
const { setTitle } = useTitle('版块')
const currentSlug = computed(() => {
  const boardId = route.params.slug as string
  // if (boardId !== 0) {
  //   setTitle(route.params.name as string)
  // }

  return boardId
})
let lastSlug = currentSlug.value
const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<Topic>(
  getTopicsByBoardSlug,
  currentSlug,
)

watch(
  () => currentSlug.value,
  (to) => {
    if (!to || to === lastSlug) return
    lastSlug = to
    fetch(true)
  },
)
</script>
