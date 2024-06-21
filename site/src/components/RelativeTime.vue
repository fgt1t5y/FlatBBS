<template>
  <NTooltip>
    <template #trigger>
      <NText :depth="3">{{ relativeTime[1] }}</NText>
    </template>
    {{ relativeTime[0] }}
  </NTooltip>
</template>

<script setup lang="ts">
import { formatTime } from '@/utils'
import { NText, NTooltip } from 'naive-ui'

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
