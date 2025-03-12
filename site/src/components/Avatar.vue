<template>
  <img class="avatar" :src="src" :alt="alt || $t('avatar')" />
</template>

<script setup lang="ts">
defineOptions({
  name: 'Avatar',
})

const props = defineProps<{
  src?: string
  alt?: string
}>()
</script>
