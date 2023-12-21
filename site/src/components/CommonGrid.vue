<template>
  <header v-if="isDesktop" class="grid-sider">
    <slot name="sider" />
  </header>
  <slot name="content" />
</template>

<script setup lang="ts">
import '@/style/CommonGrid.css'
import { isDesktop } from '@/utils'

defineOptions({
  name: 'CommonGrid',
})
</script>
