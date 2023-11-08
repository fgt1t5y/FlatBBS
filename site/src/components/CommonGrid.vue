<template>
  <header class="grid-sider">
    <slot name="sider" />
  </header>
  <main class="grid-content">
    <slot name="content" />
  </main>
  <footer class="grid-panels">
    <slot name="panels" />
  </footer>
</template>

<script setup lang="ts">
import '@/style/CommonGrid.css'

defineOptions({
  name: 'CommonGrid',
})
</script>
