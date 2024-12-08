<template>
  <div class="my-6">
    <div v-if="loading" class="flex justify-center">
      <Loader class="size-12 animate-spin" />
    </div>
    <div
      v-if="error && !loading"
      class="flex flex-col items-center justify-center gap-6"
    >
      <span class="text-xl">{{ error.message }}</span>
      <button class="btn btn-primary btn-md" @click="emits('retry')">
        {{ $t('action.retry') }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Loader } from '@vicons/tabler'

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
</script>
