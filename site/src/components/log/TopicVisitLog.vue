<template>
  <div class="visit-log topic-visit-log">
    <div class="visit-log-info">
      <RelativeTime :time="item.updated_at" />
      <span>{{ $t('topic.visited') }}</span>
    </div>
    <div class="visit-log-title">
      <RouterLink
        :to="{ name: 'topic', params: { topic_id: item.visitable.id } }"
        :title="item.visitable.title"
      >
        {{ item.visitable.title }}
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from '../RelativeTime.vue'
import type { IVisitLog, Topic } from '@/types'

defineOptions({
  name: 'TopicVisitLog',
})

const props = defineProps<{
  item: IVisitLog<Topic>
}>()
</script>
