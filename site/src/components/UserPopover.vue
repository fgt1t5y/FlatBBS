<template>
  <Popover
    placement="bottom-start"
    :class="$attrs.class"
    :duration="[1200, 400]"
    @show="loadUserDetail"
  >
    <slot />
    <template #body>
      <div class="p-3" style="width: 350px">
        <div v-if="loading" class="flex justify-center">
          <i class="icon-5xl ti ti-loader animate-spin"></i>
        </div>
        <SimpleUserInfo v-else :user="user" show-description />
      </div>
    </template>
  </Popover>
</template>

<script setup lang="ts">
import { getUserDetailByUsername } from '@/services'
import { useRequest } from 'alova/client'
import { ref } from 'vue'
import SimpleUserInfo from './SimpleUserInfo.vue'
import Popover from './Popover.vue'

import type { User } from '@/types'

defineOptions({
  name: 'UserPopover',
})

interface UserPopoverProps {
  username: string
  initialData?: User
}

const props = defineProps<UserPopoverProps>()

const user = ref<User | undefined>(props.initialData)

const { send, loading } = useRequest(
  () => getUserDetailByUsername(props.username),
  {
    immediate: false,
  },
)

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
