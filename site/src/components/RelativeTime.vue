<template>
  <Tooltip :text="relativeTime[0]">
    <time class="text-muted">{{ relativeTime[1] }}</time>
  </Tooltip>
</template>

<script setup lang="ts">
import { formatTime } from '@/utils'
import Tooltip from './Tooltip.vue';

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
