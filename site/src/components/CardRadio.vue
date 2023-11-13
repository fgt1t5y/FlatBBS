<template>
  <div
    class="card-radio"
    role="radio"
    :title="label"
    :class="cardClass"
    @click="emits('click')"
  >
    <div class="card-radio-label">
      <slot />
      {{ label }}
    </div>
    <button class="card-radio-handle" @click="emits('click')">
      <CheckIcon v-show="checked" size="18px" />
    </button>
  </div>
</template>

<script setup lang="ts">
import '@/style/CardRadio.css'
import { CheckIcon } from 'tdesign-icons-vue-next'
import { computed } from 'vue'

defineOptions({
  name: 'CardRadio',
})

interface CardRadioProps {
  checked: boolean
  label: string
}

const props = withDefaults(defineProps<CardRadioProps>(), {
  checked: false,
  label: '',
})
const emits = defineEmits<{
  (e: 'click'): void
}>()
const cardClass = computed(() => {
  return {
    'card-radio-seleted': props.checked,
  }
})
</script>
