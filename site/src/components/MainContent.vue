<template>
  <div class="grid-main">
    <div class="grid-main-content">
      <slot />
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

defineOptions({
  name: 'MainContent',
})

interface MainContentProps {
  disablePanels?: boolean
}

const props = withDefaults(defineProps<MainContentProps>(), {
  disablePanels: false,
})
</script>
