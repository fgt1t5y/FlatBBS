<template>
  <div :class="itemClass">
    <slot
      v-for="(item, index) of items"
      v-bind="{ key: index }"
      :item="item"
      :index="index"
    />
    <NDivider v-if="isEnd && items.length" dashed>没有更多了</NDivider>
  </div>
</template>

<script setup lang="ts" generic="T">
import '@/style/CommonList.css'
import { computed } from 'vue'
import { NDivider } from 'naive-ui'

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
