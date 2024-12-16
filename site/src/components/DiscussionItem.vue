<template>
  <div class="item p-3 border-bt flex gap-2">
    <Avatar class="size-8 md:size-12" :src="discussion.author.avatar_uri" rounded />
    <div>
      <div class="flex gap-2">
        <span>{{ discussion.author.display_name }}</span>
        <RelativeTime :time="discussion.created_at" />
      </div>
      <ContentRenderer :html="discussion.content" />
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
