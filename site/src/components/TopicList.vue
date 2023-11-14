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
        <RouterLink :to="idToUri(item.id)">{{ item.title }}</RouterLink>
      </div>
      <div class="topic-footer">
        <NTag
          round
          :bordered="false"
          :color="{ color: item.board.color, textColor: 'white' }"
        >
          {{ item.board.name }}
        </NTag>
        <NButton round quaternary size="small" title="发表评论">
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
import { NAvatar, NText, NButton, NTag } from 'naive-ui'
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
</script>
