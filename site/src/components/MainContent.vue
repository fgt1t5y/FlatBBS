<template>
  <div class="grid-main">
    <div class="grid-main-content">
      <NFlex
        v-if="loading"
        style="width: 100%; height: 300px"
        vertical
        justify="center"
        align="center"
      >
        <NSpin :delay="200" description="加载中" />
      </NFlex>
      <NFlex
        v-else-if="error"
        style="width: 100%; height: 300px"
        vertical
        justify="center"
        align="center"
      >
        <NH3>{{ error.message }}</NH3>
        <NButton type="primary" round @click="emits('retry')">重试</NButton>
      </NFlex>
      <slot v-else />
    </div>
    <div v-if="isDesktop && !disablePanels" class="grid-main-panels">
      <div class="grid-main-panels-inner">
        <slot name="panels" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { isDesktop } from '@/utils'
import { watch } from 'vue'
import { NFlex, NSpin, NButton, NH3 } from 'naive-ui'

defineOptions({
  name: 'MainContent',
})

interface MainContentProps {
  disablePanels?: boolean
  loading?: boolean
  error?: Error
}

const props = withDefaults(defineProps<MainContentProps>(), {
  disablePanels: false,
  loading: false,
  error: undefined,
})

const emits = defineEmits<{
  (e: 'retry'): void
}>()

watch(
  () => props.error,
  (v) => {
    console.log(v?.message)
  },
)
</script>
