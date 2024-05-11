<template>
  <NFlex v-if="isLoading" vertical justify="center" align="center">
    <NSpin :delay="200" description="加载中" />
  </NFlex>
  <NFlex v-if="isFailed" vertical justify="center" align="center">
    <NButton type="primary" round @click="emits('retry')">重试</NButton>
  </NFlex>
</template>

<script setup lang="ts">
import { NFlex, NButton, NSpin } from 'naive-ui'

defineOptions({
  name: 'RequestPlaceholder',
})

interface RequestPlaceholderProps {
  isLoading: boolean
  isFailed: boolean
}

const props = defineProps<RequestPlaceholderProps>()
const emits = defineEmits<{
  (e: 'retry'): any
}>()
</script>
