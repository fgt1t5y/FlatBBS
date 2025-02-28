<template>
  <div class="visit-log user-visit-log">
    <div class="visit-log-info">
      <RelativeTime :time="item.updated_at" />
      <span>{{ $t('user.visited') }}</span>
    </div>
    <div class="visit-log-title">
      <RouterLink
        :to="{ name: 'user', params: { username: item.visitable.username } }"
        :title="item.visitable.display_name"
      >
        {{ item.visitable.display_name }}
      </RouterLink>
    </div>
    <div
      v-if="item.visitable.introduction"
      class="text-base text-muted max-h-12 sm:max-h-max overflow-hidden"
      v-text="item.visitable.introduction"
    ></div>
  </div>
</template>

<script setup lang="ts">
import RelativeTime from '../RelativeTime.vue'

import type { UserVisitLog, User } from '@/types'

defineOptions({
  name: 'UserVisitLogItem',
})

const props = defineProps<{
  item: UserVisitLog<User>
}>()
</script>
