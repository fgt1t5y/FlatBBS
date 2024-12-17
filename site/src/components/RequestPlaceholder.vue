<template>
  <div class="my-6 empty:my-0">
    <div v-if="loading" class="flex justify-center">
      <Loader class="size-12 animate-spin" />
    </div>
    <div
      v-if="error && !loading"
      class="flex flex-col items-center justify-center gap-6"
    >
      <span class="text-xl">{{ errorMessage }}</span>
      <button class="btn btn-primary btn-md" @click="emits('retry')">
        {{ $t('action.retry') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Loader } from '@vicons/tabler'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

defineOptions({
  name: 'RequestPlaceholder',
})

interface RequestPlaceholderProps {
  loading: boolean
  error?: Error
}

const props = defineProps<RequestPlaceholderProps>()
const emits = defineEmits<{
  (e: 'retry'): any
}>()
const { t } = useI18n()

const errorMessage = computed(() => {
  if (!props.error?.message) {
    return null
  }

  if (props.error.message.startsWith('i18n$')) {
    return t(props.error.message.slice(5))
  }

  return props.error.message
})
</script>
