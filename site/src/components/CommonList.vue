<template>
  <div :class="itemClass">
    <slot
      v-for="(item, index) of items"
      v-bind="{ key: index }"
      :item="item"
      :index="index"
    />
    <div v-if="isEnd && items.length" class="text-center text-lg mt-2">
      没有更多了
    </div>
  </div>
</template>

<script setup lang="ts" generic="T">
import { computed } from 'vue'

defineOptions({
  name: 'CommonList',
})

defineSlots<{
  default(props: { item: T; index: number }): any
}>()

interface CommonListProps {
  items: T[]
  hoverable?: boolean
  clickable?: boolean
  isEnd?: boolean
}

const props = withDefaults(defineProps<CommonListProps>(), {
  hoverable: false,
  clickable: false,
  isEnd: false,
})

const itemClass = computed(() => {
  return {
    list: true,
    'list-hover': props.hoverable,
    'list-link': props.clickable,
  }
})
</script>
