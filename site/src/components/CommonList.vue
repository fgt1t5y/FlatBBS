<template>
  <div class="list">
    <slot v-for="(item, index) of items" :item="item" :index="index" />
  </div>
  <RequestPlaceholder :loading="loading" :error="error" @retry="emits('retry')" />
  <div
    v-if="isEnd && !loading"
    class="text-center text-muted p-3 border-bt"
  >
    {{ $t('message.list_no_more') }}
  </div>
</template>

<script setup lang="ts" generic="T extends { id: number }">
import RequestPlaceholder from './RequestPlaceholder.vue';

defineOptions({
  name: 'CommonList',
})

defineSlots<{
  default(props: { item: T; index: number }): any
}>()

type CommonListProps = {
  items: T[]
  isEnd?: boolean
  loading?: boolean
  error?: Error
}

const props = withDefaults(defineProps<CommonListProps>(), {
  isEnd: false,
  loading: false,
  error: undefined
})
const emits = defineEmits<{
  (e: 'retry'): any
}>()
</script>
