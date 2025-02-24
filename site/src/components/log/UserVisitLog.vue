<template>
  <div class="visit-log user-visit-log">
    <div class="visit-log-info">
      <RelativeTime :time="item.updated_at" />
      <span>{{ $t('user.visited') }}</span>
    </div>
    <div class="visit-log-title">
      <RouterLink
        :to="{ name: 'topic', params: { topic_id: item.visitable.id } }"
        :title="item.visitable.display_name"
      >
        {{ item.visitable.display_name }}
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from '../RelativeTime.vue'

import type { IVisitLog, User } from '@/types'

defineOptions({
  name: 'UserVisitLog',
})

const props = defineProps<{
  item: IVisitLog<User>
}>()
</script>
