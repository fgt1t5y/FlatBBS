<template>
  <div class="item">
    <div class="flex gap-3">
      <NAvatar :size="40" :src="discussion.author.avatar_uri" round />
      <div class="flex text-base gap-2">
        <span>{{ discussion.author.display_name }}</span>
        <RelativeTime :time="discussion.created_at" />
      </div>
    </div>
    <div class="text-base" v-html="discussion.content"></div>
    <div class="flex justify-between items-center">
      <span class="text-muted"># {{ !index ? '题主楼' : index }}</span>
      <NButton size="small" round secondary>回复</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Discussion } from '@/types'
import { NAvatar, NButton } from 'naive-ui'
import RelativeTime from './RelativeTime.vue'

defineOptions({
  name: 'DiscussionItem',
})

interface TopicListProps {
  discussion: Discussion
  index: number
}

const props = defineProps<TopicListProps>()
</script>
