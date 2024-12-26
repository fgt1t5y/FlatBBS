<template>
  <Teleport v-if="mount" to="body">
    <Transition name="modal">
      <div v-show="visible" class="modal">
        <div class="h-full w-full bg-indigo-900 opacity-50"></div>
        <div class="modal-wrapper">
          <FocusTrap :active="enableFocusTrap">
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
          </FocusTrap>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { nextTick, ref, watch } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { X } from '@vicons/tabler'
import { FocusTrap } from './FocusTrap'

defineOptions({
  name: 'Modal',
})

const props = defineProps<{
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
const enableFocusTrap = ref<boolean>(false)

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
      nextTick(() => {
        enableFocusTrap.value = true
      })
    } else {
      emits('hide')
      enableFocusTrap.value = false
    }
  },
)

onClickOutside(modalInnerRef, onClickOutsideHandle)
</script>
