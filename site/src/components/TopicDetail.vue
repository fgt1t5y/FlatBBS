<template>
  <div class="item p-3 border-bt flex gap-2">
    <Avatar class="size-8 md:size-12" :src="topic.author.avatar_uri" rounded />
    <div>
      <div class="flex text-base gap-2">
        <span>{{ topic.author.display_name }}</span>
        <RelativeTime :time="topic.created_at" />
      </div>
      <ContentRenderer :html="topic.content" />
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import ContentRenderer from '@/components/ContentRenderer.vue'

import type { Topic } from '@/types'

defineOptions({
  name: 'TopicDetail',
})

interface TopicListDetailProps {
  topic: Topic
}

const props = defineProps<TopicListDetailProps>()
</script>
