<template>
  <NTooltip>
    <template #trigger>
      <NText :depth="3">{{ relativeTime }}</NText>
    </template>
    {{ time }}
  </NTooltip>
</template>

<script setup lang="ts">
import { fromNow } from '@/utils'
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
const relativeTime = fromNow(props.time)
</script>
