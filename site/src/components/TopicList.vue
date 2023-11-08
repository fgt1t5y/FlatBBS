<template>
  <NList clickable hoverable>
    <NListItem v-for="item in topics" :key="item.id" class="topic-list-item">
      <div class="topic-header">
        <NAvatar
          :src="getAvatarPath(item.author.avatar_uri!)"
          :size="20"
          round
        />
        <NText>{{ item.author.username }}</NText>
        <NText depth="3">{{ fromNow(item.created_at) }}</NText>
      </div>
      <div class="topic-title">
        <RouterLink :to="idToUri(item.id)">{{ item.title }}</RouterLink>
      </div>
      <div class="topic-footer">
        <NTag round :bordered="false">
          {{ item.board.name }}
        </NTag>
        <div class="topic-info">
          <NButton round secondary size="small" title="发表评论">
            <template #icon>
              <ChatMessageIcon size="16px" />
            </template>
            {{ item.reply_count }}
          </NButton>
        </div>
      </div>
    </NListItem>
  </NList>
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="fetchTopics">重试</NButton>
  </div>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services'
import '@/style/TopicList.css'
import { ref, onMounted, watch } from 'vue'
import type { Topic } from '@/types'
import { useRoute, RouterLink } from 'vue-router'
import {
  NSpin,
  NAvatar,
  NText,
  NList,
  NListItem,
  NButton,
  NTag,
} from 'naive-ui'
import { fromNow, getAvatarPath } from '@/utils'
import { ChatMessageIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'TopicList',
})

const topics = ref<Topic[] | null>(null)
const isLoading = ref<boolean>(false)
const isFailed = ref<boolean>(false)
const limit = 10
const offset = 0
const route = useRoute()
const idToUri = (id: number) => '/topic/' + String(id)
const fetchTopics = () => {
  isLoading.value = true
  isFailed.value = false
  getTopicList(offset, limit)
    .then((res) => {
      topics.value = res.data.data!
    })
    .catch(() => {
      isFailed.value = true
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
