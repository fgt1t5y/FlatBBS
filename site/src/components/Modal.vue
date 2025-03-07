<template>
  <Teleport v-if="mount" to="body">
    <Transition
      name="modal"
      @after-enter="onAfterEnter"
      @after-leave="onAfterLeave"
    >
      <div v-show="visible" class="modal">
        <div class="h-full w-full bg-primary-900 opacity-50"></div>
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
              <div class="modal-header">
                <span class="text-base font-bold">{{ title }}</span>
                <button v-if="closeButton" @click="closeModal">
                  <i class="icon ti ti-x"></i>
                </button>
              </div>
              <div class="modal-body">
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
import { nextTick, ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
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

let triggerElement: HTMLElement | null = null

const closeModal = () => {
  visible.value = false
}

const onClickOutsideHandle = () => {
  if (mount.value && visible.value) {
    closeModal()
  }
}

const onAfterEnter = () => {
  triggerElement = document.activeElement as HTMLElement
  emits('show')
  nextTick(() => {
    enableFocusTrap.value = true
  })
}

const onAfterLeave = () => {
  emits('hide')
  enableFocusTrap.value = false
  if (triggerElement) {
    triggerElement.focus()
  }
  triggerElement = null
}

onClickOutside(modalInnerRef, onClickOutsideHandle)
</script>
