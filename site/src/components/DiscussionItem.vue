<template>
  <div class="item p-3 border-bt">
    <div class="flex gap-3">
      <Avatar class="size-10" :src="discussion.author.avatar_uri" rounded />
      <div class="flex text-base gap-2">
        <span>{{ discussion.author.display_name }}</span>
        <RelativeTime :time="discussion.created_at" />
      </div>
    </div>
    <ContentRenderer :html="discussion.content" />
    <div class="flex justify-between items-center">
      <span class="text-muted"># {{ index + 1 }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import ContentRenderer from './ContentRenderer.vue'

import type { Discussion } from '@/types'

defineOptions({
  name: 'DiscussionItem',
})

interface TopicListProps {
  discussion: Discussion
  index: number
}

const props = defineProps<TopicListProps>()
</script>
