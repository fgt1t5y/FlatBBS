<template>
  <div class="flex flex-col gap-2">
    <div class="flex gap-2">
      <Avatar class="size-16" :src="user?.avatar_uri" rounded />
      <div>
        <div class="text-base font-bold">{{ user?.display_name }}</div>
        <div class="text-base text-muted">@{{ user?.username }}</div>
      </div>
    </div>
    <div v-if="showDescription">
      {{ user?.introduction }}
    </div>
  </div>
</template>

<script setup lang="ts">
import Avatar from './Avatar.vue'

import type { User } from '@/types'

defineOptions({
  name: 'SimpleUserInfo',
})

interface SimpleUserInfoProps {
  user?: User
  showDescription?: boolean
}

const props = defineProps<SimpleUserInfoProps>()
</script>
