<template>
  <img
    :class="{ 'rounded-full': rounded, 'rounded-sm': !rounded }"
    :src="src"
    :alt="alt || $t('avatar')"
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
