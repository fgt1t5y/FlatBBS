<template>
  <img
    :class="{ 'rounded-full': rounded, rounded: !rounded }"
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
