<template>
  <div :class="itemClass">
    <slot />
  </div>
</template>

<script setup lang="ts">
import '@/style/CommonList.css'
import { computed } from 'vue'

defineOptions({
  name: 'CommonList',
})

interface CommonListProps {
  hoverable?: boolean
  clickable?: boolean
}

const props = withDefaults(defineProps<CommonListProps>(), {
  hoverable: false,
  clickable: false,
})

const itemClass = computed(() => {
  return {
    list: true,
    'list-hover': props.hoverable,
    'list-link': props.clickable,
  }
})
</script>
