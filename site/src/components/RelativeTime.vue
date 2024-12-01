<template>
  <span class="text-muted" :title="relativeTime[0]">{{ relativeTime[1] }}</span>
</template>

<script setup lang="ts">
import { formatTime } from '@/utils'

defineOptions({
  name: 'RelativeTime',
})

interface RelativeTimeProps {
  time: string
}

const props = withDefaults(defineProps<RelativeTimeProps>(), {
  time: Date.toString(),
})
const relativeTime = formatTime(props.time)
</script>
