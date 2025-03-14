<template>
  <div class="visit-log topic-visit-log">
    <div class="visit-log-info">
      <RelativeTime :time="item.updated_at" />
      <span>{{ $t('topic.visited') }}</span>
    </div>
    <div class="visit-log-title">
      <RouterLink
        :to="{ name: 'topic', params: { topicId: item.visitable.id } }"
        :title="item.visitable.title"
      >
        {{ item.visitable.title }}
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
        :to="{ name: 'board', params: { boardSlug: item.visitable.board.slug } }"
      >
        {{ item.visitable.board.name }}
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import RelativeTime from '../RelativeTime.vue'

import type { UserVisitLog, Topic } from '@/types'

defineOptions({
  name: 'TopicVisitLogItem',
})

const props = defineProps<{
  item: UserVisitLog<Topic>
}>()

const previewText = computed(() => {
  if (!props.item.visitable.text) {
    return ''
  }
  return props.item.visitable.text.slice(0, 100)
})
</script>
