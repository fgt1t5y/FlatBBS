<template>
  <div class="discussion-list-item item">
    <div class="discussion-avatar">
      <NAvatar :size="40" :src="discussion.author.avatar_uri" round />
    </div>
    <div class="discussion-body">
      <NText>{{ discussion.author.display_name }}</NText>
      <RelativeTime :time="discussion.created_at" />
      <div class="discussion-content" v-html="discussion.content"></div>
      <div class="discussion-footer">
        <NText :depth="3"># {{ !index ? '题主楼' : index }}</NText>
        <NButton size="small" round quaternary>回复</NButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Discussion } from '@/types'
import '@/style/DiscussionItem.css'
import { NAvatar, NButton, NText } from 'naive-ui'
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
