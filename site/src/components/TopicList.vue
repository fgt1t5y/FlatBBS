<template>
  <div class="topic-list">
    <div v-for="item in topics" class="topic-list-item item">
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
        <RouterLink :to="idToUri(item.id)" :title="item.title">
          {{ item.title }}
        </RouterLink>
      </div>
      <div class="topic-footer">
        <NButton secondary round size="small" title="前往话题所属版块">
          <RouterLink :to="boardIdToUri(item.board.id, item.board.name)">
            {{ item.board.name }}
          </RouterLink>
        </NButton>
        <NButton round secondary size="small" title="发表讨论">
          <template #icon>
            <ChatMessageIcon size="16px" />
          </template>
          {{ item.reply_count }}
        </NButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicList.css'
import type { Topic } from '@/types'
import { RouterLink } from 'vue-router'
import { NAvatar, NText, NButton } from 'naive-ui'
import { fromNow, getAvatarPath } from '@/utils'
import { ChatMessageIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'TopicList',
})

interface TopicListProps {
  topics: Topic[]
}

const props = withDefaults(defineProps<TopicListProps>(), {
  topics: () => [],
})

const idToUri = (id: number) => `/topic/${id}`
const boardIdToUri = (id: number, name: string) => `/board/${id}/${name}`
</script>
