<template>
  <div ref="obTarget" class="observe-target"></div>
</template>

<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core'
import { ref, watch } from 'vue'

defineOptions({
  name: 'IntersectionObserver',
})

interface IntersectionObserverProps {
  disabled?: boolean
}

const props = withDefaults(defineProps<IntersectionObserverProps>(), {
  disabled: true,
})
const emits = defineEmits<{
  (e: 'reach'): void
}>()
const obTarget = ref<HTMLElement>()

const { pause, resume } = useIntersectionObserver(
  obTarget,
  ([{ isIntersecting }]) => {
    if (props.disabled) return
    isIntersecting && emits('reach')
  },
  {
    rootMargin: '40px',
  },
)

watch(
  () => props.disabled,
  (value) => (value ? pause() : resume()),
)
</script>
