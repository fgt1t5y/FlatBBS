<template>
  <div class="flex flex-col gap-1 p-3 border-bt">
    <div class="flex gap-2">
      <Avatar class="size-5" :src="topic.author.avatar_uri" rounded />
      <span>{{ topic.author.display_name }}</span>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div class="text-base">
      <RouterLink :to="`/topic/${topic.id}`" :title="topic.title">
        {{ topic.title }}
      </RouterLink>
    </div>
    <div class="flex justify-between">
      <RouterLink :to="`/board/${topic.board.slug}`">
        <button class="btn btn-air btn-sm rounded-3xl">{{ topic.board.name }}</button>
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Topic } from '@/types'
import { RouterLink } from 'vue-router'
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'

defineOptions({
  name: 'TopicItem',
})

interface TopicListItemProps {
  topic: Topic
}

const props = defineProps<TopicListItemProps>()
</script>
