<template>
  <div class="topic-list">
    <article v-for="item in topics" class="topic-list-item">
      <div class="topic-title">
        <RouterLink to="/">{{ item.title }}</RouterLink>
        <div class="topic-reply-count">{{ item.reply_count }}</div>
      </div>
      <div class="topic-info">
        <Avatar
          :image-url="getAvatarPath(item.author.avatar_uri!)"
          :size="20"
        />
        <TypographyText>{{ item.author.username }}</TypographyText>
        <TypographyText type="secondary">发布于 {{ fromNow(item.created_at) }}</TypographyText>
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
import { useRoute, RouterLink } from 'vue-router'
import { Spin, Avatar, TypographyText } from '@arco-design/web-vue'
import { fromNow, getAvatarPath } from '@/utils'

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
