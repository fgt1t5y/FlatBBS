<template>
  <PageTitle :title="current" />
  <TopicEditor :board-id="currentBoardId" @success="refresh" />
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
    <NH5 v-if="t.noMore.value" class="text-center" :align-text="true">
      没有更多了
    </NH5>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NSpin, NH5, NButton } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchData } from '@/utils/useFetchData'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'
import { useTitle } from '@/utils/useTitle'

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
  t.fetch(last, limit, currentBoardId.value)
}
const refresh = () => {
  topics.value = []
  last = 0
  t.noMore.value = false
  getTopic()
}

watch(() => route.params.board_id, refresh)
</script>
