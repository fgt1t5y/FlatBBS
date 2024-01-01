<template>
  <div class="topic-list-item chunk">
    <div class="topic-header">
      <NAvatar :src="topic.author.avatar_uri" :size="20" round />
      <NText>{{ topic.author.display_name }}</NText>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div class="topic-title">
      <RouterLink :to="idToUri(topic.id)" :title="topic.title">
        {{ topic.title }}
      </RouterLink>
    </div>
    <div class="topic-footer">
      <NButton secondary round size="small" title="前往话题所属版块">
        <RouterLink :to="`/board/${topic.board.slug}`">
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
import { RouterLink } from 'vue-router'
import { NAvatar, NText, NButton } from 'naive-ui'
import { ChatMessageIcon } from 'tdesign-icons-vue-next'
import RelativeTime from './RelativeTime.vue'

defineOptions({
  name: 'TopicListItem',
})

interface TopicListItemProps {
  topic: Topic
}

const props = defineProps<TopicListItemProps>()
const idToUri = (id: number) => `/topic/${id}`
</script>
