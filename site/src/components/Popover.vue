<template>
  <div @mouseleave="onMouseLeave">
    <div
      ref="wrapperRef"
      @mouseenter="onMouseEnter"
      @mouseleave="clearOpenTimer"
      @click="onClick"
    >
      <slot />
    </div>
    <Teleport to="body">
      <Transition>
        <div
          v-if="mountPopover"
          v-show="isPositioned"
          :id="popoverId"
          ref="bodyRef"
          role="tooltip"
          class="popover"
          :style="floatingStyles"
          @mouseenter="onMouseEnterPopover"
          @mouseleave="onMouseLeavePopover"
          @keydown="onKeyDown"
        >
          <FocusTrap :active="enableFocusTrap" auto-focus>
            <slot name="body" />
          </FocusTrap>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { useFloating, autoUpdate } from '@floating-ui/vue'
import { computed, onDeactivated, ref, useId, watch } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { FocusTrap } from './FocusTrap'

import type { Placement } from '@floating-ui/vue'

defineOptions({
  name: 'Popover',
})

interface PopoverProps {
  duration?: [number, number] | number
  placement?: Placement
  trigger?: 'hover' | 'click' | 'manual'
  unmountOnClose?: boolean
  focusTrap?: boolean
}

const props = withDefaults(defineProps<PopoverProps>(), {
  duration: 0,
  placement: 'bottom',
  trigger: 'hover',
  unmountOnClose: true,
})
const emits = defineEmits<{
  (e: 'show'): void
  (e: 'close'): void
  (e: 'clickOutside'): void
}>()
const modelValue = defineModel<boolean>('open', { default: false })

const popoverId = useId()
const wrapperRef = ref<HTMLElement>()
const bodyRef = ref<HTMLElement>()
const mountPopover = ref<boolean>(false)
const showPopover = ref<boolean>(false)
const isMouseInPopover = ref<boolean>(false)

const resolveDuration = () => {
  if (!props.duration) {
    return [0, 0]
  }

  if (typeof props.duration === 'number') {
    return [props.duration, props.duration]
  }

  if (Array.isArray(props.duration) && props.duration.length === 2) {
    return [props.duration[0], props.duration[1]]
  }

  return [0, 0]
}

const [openDuration, closeDuration] = resolveDuration()
let openTimerId: number | null = null
let closeTimerId: number | null = null
let onClickOutsideStop: (() => void) | null = null

const { floatingStyles, isPositioned } = useFloating(wrapperRef, bodyRef, {
  middleware: [],
  open: showPopover,
  placement: props.placement,
  whileElementsMounted: autoUpdate,
})

const openPopover = () => {
  // mount the popover when mouse enter element only
  mountPopover.value = true
  showPopover.value = true
  emits('show')

  if (props.trigger !== 'hover') {
    onClickOutsideStop = onClickOutside(bodyRef, onClickPopoverOutside, {
      ignore: [wrapperRef],
    })
  }
}

const closePopover = () => {
  emits('close')
  showPopover.value = false

  if (props.trigger !== 'hover' && onClickOutsideStop) {
    onClickOutsideStop()
  }

  if (props.unmountOnClose) {
    mountPopover.value = false
  }
}

const clearOpenTimer = () => {
  if (!openTimerId) {
    return
  }

  window.clearTimeout(openTimerId)
  openTimerId = null
}

const clearCloseTimer = () => {
  if (!closeTimerId) {
    return
  }

  window.clearTimeout(closeTimerId)
  openTimerId = null
}

const onMouseEnterPopover = () => {
  isMouseInPopover.value = true
}

const onMouseLeavePopover = () => {
  isMouseInPopover.value = false
  onMouseLeave()
}

const onMouseEnter = () => {
  if (props.trigger !== 'hover') {
    return
  }

  openTimerId = window.setTimeout(() => {
    clearOpenTimer()
    openPopover()
  }, openDuration)
}

const onMouseLeave = () => {
  if (props.trigger !== 'hover') {
    return
  }

  if (!closeDuration) {
    clearOpenTimer()
    closePopover()
    return
  }

  closeTimerId = window.setTimeout(() => {
    if (isMouseInPopover.value) {
      return
    }
    clearCloseTimer()
    closePopover()
  }, closeDuration)
}

const onClick = () => {
  if (props.trigger !== 'click') {
    return
  }

  if (showPopover.value) {
    onClickPopoverOutside()
    return
  }

  openTimerId = window.setTimeout(() => {
    clearOpenTimer()
    openPopover()
  }, openDuration)
}

const onClickPopoverOutside = () => {
  if (props.trigger === 'hover') {
    return
  }

  if (props.trigger === 'manual') {
    emits('clickOutside')
    return
  }

  closeTimerId = window.setTimeout(() => {
    clearCloseTimer()
    closePopover()
  }, closeDuration)
}

const onKeyDown = (ev: KeyboardEvent) => {
  if (ev.key === 'Escape') {
    onClickPopoverOutside()
  }
}

const enableFocusTrap = computed(() => {
  return showPopover.value && props.trigger !== 'hover' && props.focusTrap
})

watch(
  () => modelValue.value,
  (show) => {
    if (props.trigger !== 'manual') {
      return
    }

    if (show) {
      openPopover()
    } else {
      closePopover()
    }
  },
)

onDeactivated(() => {
  clearOpenTimer()
  clearCloseTimer()
  closePopover()
})
</script>
