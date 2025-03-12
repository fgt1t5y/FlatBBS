<template>
  <div class="item p-3 flex gap-2">
    <UserPopover class="shrink-0" :username="discussion.author.username">
      <RouterLink
        :to="{
          name: 'user',
          params: { username: discussion.author.username },
        }"
      >
        <Avatar class="user-avatar" :src="discussion.author.avatar_uri" />
      </RouterLink>
    </UserPopover>
    <div class="flex flex-col gap-2">
      <div class="flex gap-2">
        <RouterLink
          :to="{
            name: 'user',
            params: { username: discussion.author.username },
          }"
        >
          <span>{{ discussion.author.display_name }}</span>
        </RouterLink>
        <RelativeTime :time="discussion.created_at" />
      </div>
      <div>
        <ContentRenderer :html="discussion.content" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import ContentRenderer from './ContentRenderer.vue'

import type { Discussion } from '@/types'
import UserPopover from './UserPopover.vue'

defineOptions({
  name: 'DiscussionItem',
})

interface TopicListProps {
  discussion: Discussion
  index: number
}

const props = defineProps<TopicListProps>()
</script>
