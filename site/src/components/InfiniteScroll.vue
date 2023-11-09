<template>
  <div ref="obTarget" class="observe-target"></div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'

defineOptions({
  name: 'InfiniteScroll',
})

interface InfiniteScrollProps {
  disabled?: boolean
  root?: string
}

const props = withDefaults(defineProps<InfiniteScrollProps>(), {
  disabled: true,
  root: '',
})
const emits = defineEmits<{
  (e: 'loadmore'): void
}>()
const obTarget = ref<HTMLElement>()
const observer = ref<IntersectionObserver | null>(null)

watch(
  () => props.disabled,
  (nv) => {
    if (!nv) {
      observer.value!.observe(obTarget.value!)
    } else {
      observer.value!.disconnect()
    }
  },
)

onMounted(() => {
  observer.value = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting) emits('loadmore')
    }, { rootMargin: '10px' }
  )
  if (!props.disabled) observer.value.observe(obTarget.value!)
})
</script>
