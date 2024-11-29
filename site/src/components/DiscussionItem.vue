<template>
  <div class="discussion-list-item item">
    <div class="discussion-body">
      <div class="discussion-header">
        <NAvatar :size="40" :src="discussion.author.avatar_uri" round />
        <div class="discussion-info">
          <NText>{{ discussion.author.display_name }}</NText>
          <RelativeTime :time="discussion.created_at" />
        </div>
      </div>
      <div class="discussion-content" v-html="discussion.content"></div>
      <div class="discussion-footer">
        <NText :depth="3"># {{ !index ? '题主楼' : index }}</NText>
        <NButton size="small" round secondary>回复</NButton>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Discussion } from '@/types'
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
