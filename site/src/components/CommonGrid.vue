<template>
  <header v-if="isDesktop" class="grid-sider">
    <slot name="sider" />
  </header>
  <main class="grid-content">
    <slot name="content" />
  </main>
</template>

<script setup lang="ts">
import '@/style/CommonGrid.css'
import { isDesktop } from '@/utils'

defineOptions({
  name: 'CommonGrid',
})
</script>
