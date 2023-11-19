<template>
  <div class="topic-list">
    <TopicListItem v-for="item in topics" :key="item.id" :topic="item" />
  </div>
</template>

<script setup lang="ts">
import '@/style/TopicList.css'
import type { Topic } from '@/types'
import TopicListItem from './TopicListItem.vue'

defineOptions({
  name: 'TopicList',
})

interface TopicListProps {
  topics: Topic[]
}

const props = defineProps<TopicListProps>()
</script>
