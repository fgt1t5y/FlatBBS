<template>
  <div :class="['rounded', 'p-3', 'shadow-md', ...typeClass]">
    {{ message.message }}
  </div>
</template>

<script setup lang="ts">
import { computed, onBeforeMount, onMounted } from 'vue'

import type { IMessage } from '@/types'

defineOptions({
  name: 'MessageItem',
})

const props = defineProps<{
  message: IMessage
}>()

const emits = defineEmits<{
  (e: 'close', id: number): void
}>()

let timer: number | null = null

const typeClass = computed(() => {
  if (props.message.type === 'info') {
    return ['bg-indigo-300']
  }
  if (props.message.type === 'success') {
    return ['bg-green-300']
  }
  if (props.message.type === 'error') {
    return ['bg-red-300']
  }

  return []
})

onMounted(() => {
  timer = window.setTimeout(() => {
    emits('close', props.message.i)
  }, props.message.time)
})

onBeforeMount(() => {
  if (!timer) {
    return
  }
  window.clearTimeout(timer)
  timer = null
})
</script>
