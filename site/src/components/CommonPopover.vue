<template>
  <div @mouseleave="onMouseLeave">
    <div
      ref="wrapperRef"
      :class="$attrs.class"
      @mouseenter="onMouseEnter"
      @click="onClick"
    >
      <slot />
    </div>

    <Teleport to="body">
      <Transition>
        <div
          v-if="mountPopover"
          v-show="isPositioned"
          ref="bodyRef"
          role="tooltip"
          class="shadow-lg rounded bg-content border border-content"
          :style="floatingStyles"
        >
          <slot name="body" />
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { useFloating, autoUpdate } from '@floating-ui/vue'
import { onDeactivated, ref } from 'vue'
import { onClickOutside } from '@vueuse/core'

import type { Placement } from '@floating-ui/vue'

defineOptions({
  name: 'CommonPopover',
})

interface CommonPopoverProps {
  duration?: number | false
  placement?: Placement
  trigger?: 'hover' | 'click'
  unmountOnClose?: boolean
}

const props = withDefaults(defineProps<CommonPopoverProps>(), {
  duration: false,
  placement: 'bottom',
  trigger: 'hover',
  unmountOnClose: true,
})
const emits = defineEmits<{
  (e: 'show'): void
  (e: 'close'): void
}>()

const wrapperRef = ref<HTMLElement>()
const bodyRef = ref<HTMLElement>()
const mountPopover = ref<boolean>(false)
const showPopover = ref<boolean>(false)

let timerId: number | null = null

const { floatingStyles, isPositioned } = useFloating(wrapperRef, bodyRef, {
  middleware: [],
  open: showPopover,
  placement: props.placement,
  whileElementsMounted: autoUpdate,
})

onClickOutside(bodyRef, () => {
  closePopover()
})

const openPopover = () => {
  // mount the popover when mouse enter element only
  mountPopover.value = true
  showPopover.value = true
  emits('show')
}

const closePopover = () => {
  emits('close')
  showPopover.value = false

  if (props.unmountOnClose) {
    mountPopover.value = false
  }
}

const clearTimer = () => {
  if (!timerId) {
    return
  }

  window.clearTimeout(timerId)
  timerId = null
}

const onMouseEnter = () => {
  if (props.trigger !== 'hover') {
    return
  }

  if (!props.duration) {
    openPopover()
    return
  }

  timerId = window.setTimeout(() => {
    window.clearTimeout(timerId!)
    openPopover()
  }, props.duration)
}

const onMouseLeave = () => {
  if (props.trigger !== 'hover') {
    return
  }

  clearTimer()
  closePopover()
}

const onClick = () => {
  if (props.trigger !== 'click') {
    return
  }

  if (!props.duration) {
    openPopover()
    return
  }

  timerId = window.setTimeout(() => {
    window.clearTimeout(timerId!)
    openPopover()
  }, props.duration)
}

onDeactivated(clearTimer)
</script>
