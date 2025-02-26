<template>
  <main id="main-content" class="main-content site-layout-content">
    <div class="main-content-body">
      <RequestPlaceholder
        v-if="loading || error"
        :loading="loading"
        :error="error"
        @retry="emits('retry')"
      />
      <slot v-else />
    </div>
    <div
      v-if="isDesktop && !disablePanels"
      class="main-content-aside"
      tabindex="0"
    >
      <div class="main-content-aside-inner">
        <slot name="aside" />
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { isDesktop, pureSetTitle } from '@/utils'
import RequestPlaceholder from './RequestPlaceholder.vue'
import { onActivated } from 'vue'

defineOptions({
  name: 'MainContent',
})

interface MainContentProps {
  disablePanels?: boolean
  loading?: boolean
  error?: Error
  title?: string
}

const props = withDefaults(defineProps<MainContentProps>(), {
  disablePanels: false,
  loading: false,
  error: undefined,
  title: undefined,
})

const emits = defineEmits<{
  (e: 'retry'): void
}>()

onActivated(() => {
  if (props.title) {
    pureSetTitle(props.title)
  }
})
</script>
