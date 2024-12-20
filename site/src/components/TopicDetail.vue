<template>
  <div class="item p-3 border-bt">
    <div class="flex gap-2 items-start">
      <UserPopover :user-id="topic.author.id">
        <RouterLink
          :to="{
            name: 'user',
            params: { username: topic.author.username },
          }"
        >
          <Avatar
            class="size-8 md:size-12"
            :src="topic.author.avatar_uri"
            rounded
          />
        </RouterLink>
      </UserPopover>
      <RouterLink
        :to="{
          name: 'user',
          params: { username: topic.author.username },
        }"
      >
        <span>{{ topic.author.display_name }}</span>
      </RouterLink>
      <RelativeTime :time="topic.created_at" />
    </div>
    <div>
      <ContentRenderer :html="topic.content" />
      <div class="flex justify-between">
        <RouterLink :to="{ name: 'board', params: { slug: topic.board.slug } }">
          <button class="btn-air btn-sm rounded-3xl" :title="topic.board.name">
            {{ topic.board.name }}
          </button>
        </RouterLink>
        <button
          :class="{
            'btn-sm rounded-3xl': true,
            'btn-primary': liked,
            'btn-air': !liked,
          }"
          :title="$t('tooltip.like_this_topic')"
          @click="emits('like')"
        >
          <Heart class="size-5 inline" />
          <span>{{ $t(liked ? 'topic.liked' : 'action.like') }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from './RelativeTime.vue'
import Avatar from './Avatar.vue'
import ContentRenderer from '@/components/ContentRenderer.vue'
import UserPopover from './UserPopover.vue'
import { Heart } from '@vicons/tabler'

import type { Topic } from '@/types'

defineOptions({
  name: 'TopicDetail',
})

interface TopicListDetailProps {
  topic: Topic
  liked?: boolean
}

const props = defineProps<TopicListDetailProps>()
const emits = defineEmits<{
  (e: 'like'): void
}>()
</script>
