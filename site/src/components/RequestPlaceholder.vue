<template>
  <NSpace vertical align="center" class="chunk">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-else-if="isFailed" type="primary" round @click="emits('retry')">
      重试
    </NButton>
    <NText v-else class="text-center">没有更多了</NText>
  </NSpace>
</template>

<script setup lang="ts">
import { NSpace, NButton, NSpin, NText } from 'naive-ui'

defineOptions({
  name: 'RequestPlaceholder',
})

interface RequestPlaceholderProps {
  isLoading: boolean
  isFailed: boolean
  noMore?: boolean
}

const props = defineProps<RequestPlaceholderProps>()
const emits = defineEmits<{
  (e: 'retry'): any
}>()
</script>
