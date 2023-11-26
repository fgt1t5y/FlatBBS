<template>
  <div class="grid-content-inner">
    <slot />
  </div>
  <div v-if="isDesktop" class="grid-panels">
    <div class="grid-panels-inner">
      <slot name="panels" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { isDesktop } from '@/utils'

defineOptions({
  name: 'MainContent',
})
</script>
