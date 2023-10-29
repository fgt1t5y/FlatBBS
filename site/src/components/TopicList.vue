<template>
  <div class="topic-list">
    <div v-for="item in topics" class="topic-list-item">
      <div class="topic-header">
        <span>{{ item.title }}</span>
        <span class="topic-board" :style="{backgroundColor: item.board.color}">
          {{ item.board.name }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services'
import '@/style/TopicList.css'
import { ref, onMounted, watch } from 'vue'
import type { Topic } from '@/types'
import { useRoute } from 'vue-router'

defineOptions({
  name: 'TopicList',
})

const topics = ref<Topic[] | null>(null)
const limit = 10
const offset = 0
const route = useRoute()
const fetchTopics = () => {
  getTopicList(offset, limit).then((res) => {
    topics.value = res.data.data!
  })
}

watch(
  () => route.params.id,
  (board_id) => {
    console.log(board_id)
  },
)

onMounted(() => {
  fetchTopics()
})
</script>
