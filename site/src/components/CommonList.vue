<template>
  <div class="list">
    <slot v-for="(item, index) of items" :item="item" :index="index" />
  </div>
  <div
    v-if="isEnd && items && items.length"
    class="text-center text-muted p-3 border-bt"
  >
    {{ $t('message.list_no_more') }}
  </div>
</template>

<script setup lang="ts" generic="T extends { id: number }">
defineOptions({
  name: 'CommonList',
})

defineSlots<{
  default(props: { item: T; index: number }): any
}>()

type CommonListProps = {
  items: T[]
  isEnd?: boolean
}

const props = withDefaults(defineProps<CommonListProps>(), {
  isEnd: false,
})
</script>
