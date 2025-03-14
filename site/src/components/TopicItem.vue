<template>
  <div class="item p-3 flex flex-col gap-1">
    <div class="flex gap-2">
      <UserPopover :username="topic.author.username">
        <RouterLink
          class="flex gap-2"
          :to="{
            name: 'user',
            params: { username: topic.author.username },
          }"
        >
          <Avatar class="user-avatar size-5" :src="topic.author.avatar_uri" />
          <span>{{ topic.author.display_name }}</span>
        </RouterLink>
      </UserPopover>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div class="text-lg">
      <RouterLink
        :to="{ name: 'topic', params: { topicId: topic.id } }"
        :title="topic.title"
      >
        {{ topic.title }}
      </RouterLink>
    </div>
    <div
      v-if="previewText"
      class="text-base text-muted max-h-12 sm:max-h-max overflow-hidden"
      v-text="previewText"
    ></div>
    <div class="flex justify-between">
      <RouterLink
        class="btn btn-air btn-sm rounded-3xl"
        :to="{ name: 'board', params: { boardSlug: topic.board.slug } }"
      >
        {{ topic.board.name }}
      </RouterLink>
      <div class="flex gap-2 text-muted items-center">
        <div class="flex gap-1">
          <i class="icon ti ti-message"></i>
          <span>{{ topic.discussion_count }}</span>
        </div>
        <div class="flex gap-1">
          <i class="icon ti ti-heart"></i>
          <span>{{ topic.like_count }}</span>
        </div>
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
