<template>
  <div class="topic-list-item item">
    <div class="topic-header">
      <NAvatar
        :src="getAvatarPath(topic.author.avatar_uri!)"
        :size="20"
        round
      />
      <NText>{{ topic.author.username }}</NText>
      <NText depth="3">{{ fromNow(topic.created_at) }}</NText>
    </div>
    <div class="topic-title">
      <RouterLink :to="idToUri(topic.id)" :title="topic.title">
        {{ topic.title }}
      </RouterLink>
    </div>
    <div class="topic-footer">
      <NButton secondary round size="small" title="前往话题所属版块">
        <RouterLink :to="boardIdToUri(topic.board.id, topic.board.name)">
          {{ topic.board.name }}
        </RouterLink>
      </NButton>
      <NButton round secondary size="small" title="发表讨论">
        <template #icon>
          <ChatMessageIcon size="16px" />
        </template>
        {{ topic.reply_count }}
      </NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Topic } from '@/types'
import { fromNow, getAvatarPath } from '@/utils'
import { RouterLink } from 'vue-router'
import { NAvatar, NText, NButton } from 'naive-ui'

import { ChatMessageIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'TopicListItem',
})

interface TopicListItemProps {
  topic: Topic
}

const props = defineProps<TopicListItemProps>()

const idToUri = (id: number) => `/topic/${id}`
const boardIdToUri = (id: number, name: string) => `/board/${id}/${name}`
</script>
