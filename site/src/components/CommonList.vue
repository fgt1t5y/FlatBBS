<template>
  <div class="list">
    <slot />
  </div>
</template>

<script setup lang="ts">
import '@/style/CommonList.css'

defineOptions({
  name: 'CommonList',
})
</script>
