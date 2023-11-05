<template>
  <div class="topic-list">
    <article v-for="item in topics" class="topic-list-item">
      <div class="topic-left">
        <Avatar :image-url="getAvatarPath(item.author.avatar_uri!)" />
      </div>
      <div class="topic-right">
        <TypographyText>
          {{ item.author.username }}
        </TypographyText>
        <TypographyText type="secondary">
          {{ fromNow(item.last_reply_at) }}
        </TypographyText>
        <div class="topic-title">{{ item.title }}</div>
        <div class="topic-opt">
          <button>
            <IconMessage :size="18" />
            {{ item.reply_count }} 评论
          </button>
        </div>
      </div>
    </article>
    <Spin v-if="isLoading" :size="32" tip="加载..." />
  </div>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services'
import '@/style/TopicList.css'
import { ref, onMounted, watch } from 'vue'
import type { Topic } from '@/types'
import { useRoute } from 'vue-router'
import { TypographyText, Spin, Avatar } from '@arco-design/web-vue'
import { fromNow, getAvatarPath } from '@/utils'
import { IconMessage } from '@arco-design/web-vue/es/icon'

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
