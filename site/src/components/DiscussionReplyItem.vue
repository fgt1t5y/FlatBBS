<template>
  <div class="item p-3 flex gap-2">
    <UserPopover class="shrink-0" :username="reply.author.username">
      <RouterLink
        :to="{
          name: 'user',
          params: { username: reply.author.username },
        }"
      >
        <Avatar class="user-avatar" :src="reply.author.avatar_uri" />
      </RouterLink>
    </UserPopover>
    <div class="flex flex-col gap-2 grow">
      <div class="flex gap-2">
        <RouterLink
          :to="{
            name: 'user',
            params: { username: reply.author.username },
          }"
        >
          <span>{{ reply.author.display_name }}</span>
        </RouterLink>
        <div v-if="reply.reply_to_user" class="flex gap-2">
          <span class="text-muted">{{ $t('action.reply') }}</span>
          <RouterLink
            :to="{
              name: 'user',
              params: { username: reply.reply_to_user.username },
            }"
          >
            <span>{{ reply.reply_to_user.display_name }}</span>
          </RouterLink>
        </div>
        <RelativeTime :time="reply.created_at" />
      </div>
      <ContentRenderer :html="reply.content" />
    </div>
  </div>
</template>

<script setup lang="ts">
import Avatar from './Avatar.vue'
import UserPopover from './UserPopover.vue'
import ContentRenderer from './ContentRenderer.vue'
import RelativeTime from './RelativeTime.vue'
import type { DiscussionReply } from '@/types'

defineOptions({
  name: 'DiscussionReplyItem',
})

const props = defineProps<{
  reply: DiscussionReply
}>()
</script>
