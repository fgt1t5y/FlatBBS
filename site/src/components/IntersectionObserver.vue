<template>
  <div ref="obTarget"></div>
</template>

<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core'
import { ref, watch } from 'vue'

defineOptions({
  name: 'IntersectionObserver',
})

interface IntersectionObserverProps {
  disabled?: boolean
  rootMargin?: string
}

const props = withDefaults(defineProps<IntersectionObserverProps>(), {
  disabled: true,
  rootMargin: '40px',
})
const emits = defineEmits<{
  (e: 'reach'): void
}>()

const obTarget = ref<HTMLElement>()

const { pause, resume } = useIntersectionObserver(
  obTarget,
  ([{ isIntersecting }]) => {
    if (props.disabled) {
      return
    }
    isIntersecting && emits('reach')
  },
  {
    rootMargin: props.rootMargin,
  },
)

watch(
  () => props.disabled,
  (value) => (value ? pause() : resume()),
)
</script>
