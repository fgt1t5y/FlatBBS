<template>
  <div class="aside-panel">
    <div class="aside-panel-header">
      <h3>{{ title }}</h3>
    </div>
    <div class="aside-panel-body">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'AsidePanel',
})

const props = withDefaults(defineProps<{ title: string }>(), {
  title: '',
})
</script>
