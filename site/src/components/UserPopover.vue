<template>
  <CommonPopover
    placement="bottom-start"
    :class="$attrs.class"
    :duration="[1200, 400]"
    @show="loadUserDetail"
  >
    <slot />
    <template #body>
      <div class="p-3" style="max-width: 400px">
        <div v-if="loading" class="flex justify-center">
          <Loader class="size-12 animate-spin" />
        </div>
        <SimpleUserInfo v-else :user="user" show-description />
      </div>
    </template>
  </CommonPopover>
</template>

<script setup lang="ts">
import { getUserDetailByUsername } from '@/services'
import { useRequest } from 'alova/client'
import { ref } from 'vue'
import { Loader } from '@vicons/tabler'
import SimpleUserInfo from './SimpleUserInfo.vue'
import CommonPopover from './CommonPopover.vue'

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
