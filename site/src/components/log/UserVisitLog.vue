<template>
  <h1>{{ item.display_name }}</h1>
</template>

<script setup lang="ts">
import type { User } from '@/types';

defineOptions({
  name: 'UserVisitLog',
})

const props = defineProps<{
  item: User
}>()
</script>
