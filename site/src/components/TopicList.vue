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
        <NTag round size="small" :bordered="false">
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
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
  </div>
  <InfiniteScroll :disabled="noMore || isFailed" @loadmore="getTopic" />
  <NH5 v-if="noMore" class="text-center" :align-text="true">没有更多了</NH5>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services'
import '@/style/TopicList.css'
import { ref, watch } from 'vue'
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
  NH5,
} from 'naive-ui'
import { fromNow, getAvatarPath } from '@/utils'
import { ChatMessageIcon } from 'tdesign-icons-vue-next'
import { useFetchData } from '@/utils/useFetchData'
import InfiniteScroll from '@/components/InfiniteScroll.vue'

defineOptions({
  name: 'TopicList',
})

const topics = ref<Topic[]>([])
const limit = 10
let last = 0
const route = useRoute()
const noMore = ref<boolean>(false)
const idToUri = (id: number) => '/topic/' + String(id)
const { isFailed, isLoading, fetch, retry } =
  useFetchData<Topic[]>(getTopicList)
const getTopic = () => {
  if (noMore.value) return
  fetch(
    (data) => {
      if (data.length < limit) {
        noMore.value = true
      }
      topics.value?.push(...data)
      !noMore.value && (last = data[data.length - 1].id)
    },
    last,
    limit,
  )
}

watch(
  () => route.params.id,
  (board_id) => {
    console.log(board_id)
  },
)
</script>
