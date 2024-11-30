<template>
  <div class="mt-6 mb-6">
    <div v-if="loading" class="flex justify-center">
      <NSpin :delay="200" description="加载中" />
    </div>
    <div
      v-if="error && !loading"
      class="flex flex-col items-center justify-center gap-6"
    >
      <span class="text-xl">{{ error.message }}</span>
      <NButton type="primary" round @click="emits('retry')">重试</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { NButton, NSpin } from 'naive-ui'

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
