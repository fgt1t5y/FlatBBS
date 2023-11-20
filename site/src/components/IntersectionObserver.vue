<template>
  <div ref="obTarget" class="observe-target"></div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'

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
const observer = new IntersectionObserver(
  (entries) => {
    if (entries[0].isIntersecting) emits('reach')
  },
  { rootMargin: '40px' },
)

watch(
  () => props.disabled,
  (nv) => {
    if (!nv) {
      observer.observe(obTarget.value!)
    } else {
      observer.disconnect()
    }
  },
)

onMounted(() => {
  if (!props.disabled) observer.observe(obTarget.value!)
})
</script>
