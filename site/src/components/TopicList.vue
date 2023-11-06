<template>
  <NList>
    <NListItem v-for="item in topics" :key="item.id" class="topic-list-item">
      <div class="topic-title">
        <RouterLink :to="idToUri(item.id)">{{ item.title }}</RouterLink>
        <div class="topic-reply-count">{{ item.reply_count }}</div>
      </div>
      <div class="topic-info">
        <NAvatar
          :src="getAvatarPath(item.author.avatar_uri!)"
          :size="20"
          round
        />
        <NText>{{ item.author.username }}</NText>
        <NText depth="3">发布于 {{ fromNow(item.created_at) }}</NText>
      </div>
    </NListItem>
  </NList>
  <NSpin v-if="isLoading" :size="32" description="加载..." />
</template>

<script setup lang="ts">
import { getTopicList } from '@/services'
import '@/style/TopicList.css'
import { ref, onMounted, watch } from 'vue'
import type { Topic } from '@/types'
import { useRoute, RouterLink } from 'vue-router'
import { NSpin, NAvatar, NText, NList, NListItem } from 'naive-ui'
import { fromNow, getAvatarPath } from '@/utils'

defineOptions({
  name: 'TopicList',
})

const topics = ref<Topic[] | null>(null)
const isLoading = ref<boolean>(false)
const limit = 10
const offset = 0
const route = useRoute()
const idToUri = (id: number) => '/topic/' + String(id)
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
