<template>
  <img
    :class="{ 'rounded-full': rounded }"
    :src="src"
    :alt="alt || 'User Avatar'"
  />
</template>

<script setup lang="ts">
defineOptions({
  name: 'Avatar',
})

const props = defineProps<{
  src?: string
  alt?: string
  rounded?: boolean
}>()
</script>
