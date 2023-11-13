<template>
  <PageTitle :title="current" />
  <TopicEditor :disabled="d.isLoading.value" @submit="submitTopic" />
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
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NSpin, NButton, NText } from 'naive-ui'
import InfiniteScroll from '@/components/InfiniteScroll.vue'
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFetchData } from '@/utils/useFetchData'
import { createTopic, getTopicList } from '@/services'
import type { Topic, TopicDraft } from '@/types'
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
const d = useFetchData(createTopic, () => {
  refresh()
  window.$message.success('话题已发布！')
})
const getTopic = () => {
  if (t.noMore.value) return
  t.fetch(last, limit, currentBoardId.value)
}
const submitTopic = (topicDraft: TopicDraft) => {
  d.fetch(topicDraft.title, topicDraft.content, currentBoardId.value)
}
const refresh = () => {
  topics.value = []
  last = 0
  t.noMore.value = false
  getTopic()
}

watch(() => route.params.board_id, refresh)
</script>
