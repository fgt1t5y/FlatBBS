<template>
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" round @click="emits('retry')">
      重试
    </NButton>
    <NText v-if="noMore" class="text-center">没有更多了</NText>
  </div>
</template>

<script setup lang="ts">
import { NButton, NSpin, NText } from 'naive-ui'

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
