<template>
  <div style="width: 100%; height: 300px; display: flex; justify-content: center;">
    <NFlex v-if="loading" vertical justify="center" align="center">
      <NSpin :delay="200" description="加载中" />
    </NFlex>
    <NFlex v-if="error && !loading" vertical justify="center" align="center">
      <NH3>{{ error.message }}</NH3>
      <NButton type="primary" round @click="emits('retry')">重试</NButton>
    </NFlex>
  </div>
</template>

<script setup lang="ts">
import { NFlex, NButton, NSpin, NH3 } from 'naive-ui'

defineOptions({
  name: 'RequestPlaceholder',
})

interface RequestPlaceholderProps {
  loading: boolean
  error?: Error
}

const props = defineProps<RequestPlaceholderProps>()
const emits = defineEmits<{
  (e: 'retry'): any
}>()
</script>
