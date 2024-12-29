<template>
  <div>
    <slot v-for="(item, index) of items" :item="item" :index="index" />
    <div v-if="isEnd && items" class="text-center text-muted p-3 border-bt">
      {{ $t('message.list_no_more') }}
    </div>
  </div>
</template>

<script setup lang="ts" generic="T">
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
