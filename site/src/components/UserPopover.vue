<template>
  <CommonPopover :duration="1200" @show="loadUserDetail">
    <slot />
    <template #body>
      <div class="p-3" style="max-width: 400px;">
        <div v-if="loading" class="flex justify-center">
          <Loader class="size-12 animate-spin" />
        </div>
        <div v-else class="flex flex-col gap-2">
          <div class="flex gap-2">
            <Avatar class="size-16" :src="user?.avatar_uri" rounded />
            <div>
              <div class="text-base font-bold">{{ user?.display_name }}</div>
              <div class="text-base text-muted">@{{ user?.username }}</div>
            </div>
          </div>
          <div>
            {{ user?.introduction }}
          </div>
        </div>
      </div>
    </template>
  </CommonPopover>
</template>

<script setup lang="ts">
import { getUserDetail } from '@/services'
import { useRequest } from 'alova/client'
import { ref } from 'vue'
import { Loader } from '@vicons/tabler'
import Avatar from './Avatar.vue'
import CommonPopover from './CommonPopover.vue'

import type { User } from '@/types'

defineOptions({
  name: 'UserPopover',
})

interface UserPopoverProps {
  userId: number
  initialData?: User
}

const props = defineProps<UserPopoverProps>()

const user = ref<User | undefined>(props.initialData)

const { send, loading } = useRequest(() => getUserDetail(props.userId), {
  immediate: false,
})

const loadUserDetail = () => {
  if (user.value) {
    return
  }

  send().then((_user) => {
    if (_user) {
      user.value = _user
    }
  })
}
</script>
