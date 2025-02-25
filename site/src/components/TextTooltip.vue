<template>
  <div @mouseleave="onMouseLeave">
    <div ref="wrapperRef" @mouseenter="onMouseEnter">
      <slot />
    </div>
    <Teleport to="body">
      <div
        v-if="mountPopover"
        v-show="isPositioned"
        :id="id"
        ref="bodyRef"
        role="tooltip"
        class="tooltip popover"
        :style="floatingStyles"
        :aria-labelledby="tooltipContentId"
      >
        <span :id="tooltipContentId">{{ text }}</span>
      </div>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import { useFloating, autoUpdate } from '@floating-ui/vue'
import { onDeactivated, ref, useId } from 'vue'

defineOptions({
  name: 'TextTooltip',
  inheritAttrs: false,
})

interface TextTooltipProps {
  unmountOnClose?: boolean
  text: string
  id: string
}

const props = withDefaults(defineProps<TextTooltipProps>(), {
  unmountOnClose: false,
})

const tooltipContentId = useId()
const wrapperRef = ref<HTMLElement>()
const bodyRef = ref<HTMLElement>()
const mountPopover = ref<boolean>(false)
const showPopover = ref<boolean>(false)

const { floatingStyles, isPositioned } = useFloating(wrapperRef, bodyRef, {
  middleware: [],
  open: showPopover,
  placement: 'top',
  whileElementsMounted: autoUpdate,
})

const openPopover = () => {
  // mount the popover when mouse enter element only
  mountPopover.value = true
  showPopover.value = true
}

const closePopover = () => {
  showPopover.value = false

  if (props.unmountOnClose) {
    mountPopover.value = false
  }
}

const onMouseEnter = () => {
  openPopover()
}

const onMouseLeave = () => {
  closePopover()
}

onDeactivated(() => {
  closePopover()
})
</script>
