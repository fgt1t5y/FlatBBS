<template>
  <div class="topic-list">
    <Spin v-if="isLoading" :size="32" tip="加载..." />
    <div v-for="item in topics" class="topic-list-item">
      <div class="topic-header">
        <TypographyText type="secondary">
          {{ item.author.username }} 发布于 {{ fromNow(item.last_reply_at) }}
        </TypographyText>
      </div>
      <div class="topic-main">
        <div class="topic-title">{{ item.title }}</div>
      </div>
      <div class="topic-opt">
        <button>
          <IconMessage :size="18" />
          {{ item.reply_count }}
        </button>
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
import { TypographyText, Spin } from '@arco-design/web-vue'
import { IconMessage } from '@arco-design/web-vue/es/icon'
import { fromNow } from '@/utils'

defineOptions({
  name: 'TopicList',
})

const topics = ref<Topic[] | null>(null)
const isLoading = ref<boolean>(false)
const limit = 10
const offset = 0
const route = useRoute()
const fetchTopics = () => {
  isLoading.value = true
  getTopicList(offset, limit)
    .then((res) => {
      topics.value = res.data.data!
    })
    .finally(() => {
      isLoading.value = false
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
