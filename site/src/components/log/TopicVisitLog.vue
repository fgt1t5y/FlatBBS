<template>
  <h1>{{ item.title }}</h1>
</template>

<script setup lang="ts">
import type { Topic } from '@/types'

defineOptions({
  name: 'TopicVisitLog',
})

const props = defineProps<{
  item: Topic
}>()
</script>
