<template>
  <TextTooltip :id="id" :text="relativeTime[0]">
    <time class="text-muted" :aria-labelledby="id">{{ relativeTime[1] }}</time>
  </TextTooltip>
</template>

<script setup lang="ts">
import { formatTime } from '@/utils'
import TextTooltip from './TextTooltip.vue'
import { useId } from 'vue'

defineOptions({
  name: 'RelativeTime',
})

interface RelativeTimeProps {
  time: string
}

const props = withDefaults(defineProps<RelativeTimeProps>(), {
  time: Date.toString(),
})

const id = useId()

const relativeTime = formatTime(props.time)
</script>
