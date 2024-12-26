<template>
  <Teleport v-if="mount" to="body">
    <Transition name="modal">
      <div v-show="visible" class="modal">
        <div class="h-full w-full bg-indigo-900 opacity-50"></div>
        <div class="modal-wrapper">
          <div
            ref="modalInnerRef"
            class="modal-inner"
            :style="{
              'min-width': minWidth,
              'min-height': minHeight,
            }"
          >
            <div class="p-3 border-bt flex justify-between">
              <span class="text-base font-bold">{{ title }}</span>
              <button v-if="closeButton" @click="closeModal">
                <X class="size-5" />
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
import { ref, watch } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { X } from '@vicons/tabler'

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

const modalInnerRef = ref<HTMLElement>()
const mount = defineModel<boolean>('mount')
const visible = defineModel<boolean>('visible')

const closeModal = () => {
  visible.value = false
}

const onClickOutsideHandle = () => {
  if (mount.value && visible.value) {
    closeModal()
  }
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

onClickOutside(modalInnerRef, onClickOutsideHandle)
</script>
