<template>
  <CommonPopover placement="top" :duration="[1000, 200]">
    <slot />
    <template #body>
      <div class="p-2">{{ text }}</div>
    </template>
  </CommonPopover>
</template>

<script setup lang="ts">
import CommonPopover from './CommonPopover.vue'

defineOptions({
  name: 'CommonTooltip',
})

const props = defineProps<{
  text: string
}>()
</script>
