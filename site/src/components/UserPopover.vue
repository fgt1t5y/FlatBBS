<template>
  <div @mouseleave="onMouseLeave">
    <div ref="triggerRef" @mouseenter="onMouseEnter">
      <slot />
    </div>
    <Transition>
      <div
        v-show="isPositioned"
        ref="userPopoverRef"
        role="tooltip"
        class="shadow-lg rounded p-3 auto-color panel-border"
        :style="{
          width: '400px',
          ...floatingStyles,
        }"
      >
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
    </Transition>
  </div>
</template>

<script setup lang="ts">
import { getUserDetail } from '@/services'
import { autoUpdate, useFloating } from '@floating-ui/vue'
import { useRequest } from 'alova/client'
import { onDeactivated, ref } from 'vue'
import { Loader } from '@vicons/tabler'
import Avatar from './Avatar.vue'

import type { User } from '@/types'

defineOptions({
  name: 'UserPopover',
})

interface UserPopoverProps {
  userId: number
  initialData?: User
}

const props = defineProps<UserPopoverProps>()

const triggerRef = ref<HTMLElement>()
const userPopoverRef = ref<HTMLElement>()
const showPopover = ref(false)
const user = ref<User | undefined>(props.initialData)
let timerId: number | null = null

const { floatingStyles, isPositioned } = useFloating(
  triggerRef,
  userPopoverRef,
  {
    placement: 'bottom-start',
    open: showPopover,
    whileElementsMounted: autoUpdate,
  },
)

const { send, loading } = useRequest(() => getUserDetail(props.userId), {
  immediate: false,
})

const clearTimer = () => {
  if (!timerId) {
    return
  }

  window.clearTimeout(timerId)
  timerId = null
}

const onMouseEnter = () => {
  if (timerId) {
    return
  }

  timerId = window.setTimeout(() => {
    window.clearTimeout(timerId!)
    showPopover.value = true

    if (user.value) {
      return
    }

    send().then((_user) => {
      if (_user) {
        user.value = _user
      }
    })
  }, 1200)
}

const onMouseLeave = () => {
  clearTimer()
  showPopover.value = false
}

onDeactivated(clearTimer)
</script>
