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
    <div class="flex flex-col gap-2 grow">
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
      <ContentRenderer :html="discussion.content" />
      <div
        v-if="replies.length || repliesLoading"
        class="border border-content rounded-sm"
      >
        <CommonList
          :items="replies"
          :loading="repliesLoading"
          :error="repliesError"
          @retry="loadReplies"
        >
          <template #default="{ item }">
            <DiscussionReplyItem :reply="item" />
          </template>
        </CommonList>
      </div>
      <div v-if="hasMoreReply">
        <button
          class="btn-air btn-sm"
          :disabled="repliesLoading"
          @click="nextPage"
        >
          {{ $t('reply.load_rest', { count: restReplyCount }) }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import ContentRenderer from './ContentRenderer.vue'
import UserPopover from './UserPopover.vue'
import CommonList from './CommonList.vue'
import DiscussionReplyItem from './DiscussionReplyItem.vue'
import { getDiscussionReplies } from '@/services'
import { usePagination } from 'alova/client'

import type { Discussion } from '@/types'
import { computed, onMounted } from 'vue'

defineOptions({
  name: 'DiscussionItem',
})

const props = defineProps<{
  discussion: Discussion
}>()

const {
  loading: repliesLoading,
  data: replies,
  error: repliesError,
  page: replyPage,
  send: loadReplies,
} = usePagination(
  (page, limit) => getDiscussionReplies(page, limit, props.discussion.id),
  {
    append: true,
    preloadPreviousPage: false,
    initialPageSize: 5,
    immediate: false,
  },
)

const nextPage = () => {
  replyPage.value++
}

const hasMoreReply = computed(() => {
  return replies.value.length < props.discussion.reply_count
})

const restReplyCount = computed(() => {
  if (!hasMoreReply.value) {
    return 0
  }

  return props.discussion.reply_count - replies.value.length
})

onMounted(() => {
  replies.value = props.discussion.top_replies
})
</script>
