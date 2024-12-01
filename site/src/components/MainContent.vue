<template>
  <div class="flex grow gap-3">
    <div class="relative grow mb-14">
      <RequestPlaceholder
        v-if="loading || error"
        :loading="loading"
        :error="error"
        @retry="emits('retry')"
      />
      <slot v-else />
    </div>
    <div v-if="isDesktop && !disablePanels">
      <div class="grid-main-panels-inner">
        <slot name="panels" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { isDesktop } from '@/utils'
import RequestPlaceholder from './RequestPlaceholder.vue'

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
</script>
