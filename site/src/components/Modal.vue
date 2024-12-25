<template>
  <Teleport v-if="mount" to="body">
    <Transition name="modal">
      <div v-show="visible" class="h-full w-full fixed z-40 top-0 transition-all">
        <div class="h-full w-full bg-indigo-900 opacity-50"></div>
        <div
          class="h-full w-full absolute flex flex-col items-center top-0 justify-center"
        >
          <div
            class="bg-content flex flex-col rounded shadow border-1 border border-gray-300 dark:border-gray-700"
            :style="{
              'min-width': minWidth,
              'min-height': minHeight,
            }"
          >
            <div class="p-3 border-bt select-none">
              <span class="text-base font-bold">{{ title }}</span>
              <button
                v-if="closeButton"
                class="btn-air btn-sm"
                @click="closeModal"
              >
                <i class="i-carbon-close"></i>
              </button>
            </div>
            <div class="p-3">
              <slot />
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { watch } from 'vue'

defineOptions({
  name: 'Modal',
})

defineProps<{
  title: string
  minWidth?: string
  minHeight?: string
  closeButton?: boolean
}>()

const emits = defineEmits<{
  (e: 'show'): void
  (e: 'hide'): void
}>()

const mount = defineModel<boolean>('mount')
const visible = defineModel<boolean>('visible')

const closeModal = () => {
  visible.value = false
}

watch(
  () => visible.value,
  (v) => {
    if (v) {
      emits('show')
    } else {
      emits('hide')
    }
  },
)
</script>
