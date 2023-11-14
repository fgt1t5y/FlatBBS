<template>
  <div class="discussion-list">
    <div v-for="(item, index) in discussions" class="discussion-list-item item">
      <div class="discussion-avatar">
        <NAvatar
          :size="40"
          :src="getAvatarPath(item.author.avatar_uri!)"
          round
        />
      </div>
      <div class="discussion-body">
        <NText>{{ item.author.username }}</NText>
        <NText :depth="3">{{ fromNow(item.created_at) }}</NText>
        <div class="discussion-content" v-html="item.content"></div>
        <div class="discussion-footer">
          <NText :depth="3"># {{ !index ? '题主楼' : index }}</NText>
          <NButton size="small" round quaternary>回复</NButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Discussion } from '@/types'
import '@/style/DiscussionList.css'
import { NAvatar, NButton, NText } from 'naive-ui'
import { fromNow, getAvatarPath } from '@/utils'

defineOptions({
  name: 'DiscussionList',
})

interface TopicListProps {
  discussions: Discussion[]
}

const props = withDefaults(defineProps<TopicListProps>(), {
  discussions: () => [],
})
</script>
