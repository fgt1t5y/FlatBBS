<template>
  <div class="flex flex-col gap-1 p-3 border-bt">
    <div class="flex gap-2">
      <UserPopover :user-id="topic.author_id">
        <RouterLink
          class="flex gap-2"
          :to="{
            name: 'user',
            params: { username: topic.author.username },
          }"
        >
          <Avatar class="size-5" :src="topic.author.avatar_uri" rounded />
          <span>{{ topic.author.display_name }}</span>
        </RouterLink>
      </UserPopover>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div class="text-lg">
      <RouterLink
        :to="{ name: 'topic', params: { topic_id: topic.id } }"
        :title="topic.title"
      >
        {{ topic.title }}
      </RouterLink>
    </div>
    <div class="text-base text-muted max-h-12 sm:max-h-max overflow-hidden">
      {{ previewText }}
    </div>
    <div class="flex justify-between">
      <RouterLink :to="{ name: 'board', params: { slug: topic.board.slug } }">
        <button class="btn-air btn-sm rounded-3xl">
          {{ topic.board.name }}
        </button>
      </RouterLink>
      <div class="flex gap-1 items-center text-muted">
        <Heart class="size-5" />
        <span>{{ topic.like_count }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router'
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import { computed } from 'vue'
import UserPopover from './UserPopover.vue'
import { Heart } from '@vicons/tabler'

import type { Topic } from '@/types'

defineOptions({
  name: 'TopicItem',
})

interface TopicListItemProps {
  topic: Topic
}

const props = defineProps<TopicListItemProps>()

const previewText = computed(() => {
  if (!props.topic.text) {
    return ''
  }
  return props.topic.text.slice(0, 100)
})
</script>
