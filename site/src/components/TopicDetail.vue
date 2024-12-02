<template>
  <div class="p-3 border-bt">
    <div class="flex gap-3">
      <Avatar class="size-10" :src="topic.author.avatar_uri" rounded />
      <div class="flex text-base gap-2">
        <span>{{ topic.author.display_name }}</span>
        <RelativeTime :time="topic.created_at" />
      </div>
    </div>
    <div>
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
