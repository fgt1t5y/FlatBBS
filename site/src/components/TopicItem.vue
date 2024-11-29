<template>
  <div class="item">
    <div class="topic-header">
      <NAvatar :src="topic.author.avatar_uri" :size="20" round />
      <NText>{{ topic.author.display_name }}</NText>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div class="topic-title">
      <RouterLink :to="`/topic/${topic.id}`" :title="topic.title">
        {{ topic.title }}
      </RouterLink>
    </div>
    <div class="topic-footer">
      <NButton secondary round size="small" :title="topic.board.name">
        <RouterLink :to="`/board/${topic.board.slug}`">
          {{ topic.board.name }}
        </RouterLink>
      </NButton>
      <NButton round secondary size="small" title="发表讨论">
        <template #icon>
          <NIcon :size="18" :component="Message" />
        </template>
        {{ topic.reply_count }}
      </NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Topic } from '@/types'
import { RouterLink } from 'vue-router'
import { NAvatar, NText, NButton, NIcon } from 'naive-ui'
import { Message } from '@vicons/tabler'
import RelativeTime from './RelativeTime.vue'

defineOptions({
  name: 'TopicItem',
})

interface TopicListItemProps {
  topic: Topic
}

const props = defineProps<TopicListItemProps>()
</script>
