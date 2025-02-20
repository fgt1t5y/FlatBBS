<template>
  <Popover placement="top" :duration="[1000, 200]">
    <slot />
    <template #body>
      <div class="p-2">{{ text }}</div>
    </template>
  </Popover>
</template>

<script setup lang="ts">
import Popover from './Popover.vue'

defineOptions({
  name: 'Tooltip',
})

const props = defineProps<{
  text: string
}>()
</script>
