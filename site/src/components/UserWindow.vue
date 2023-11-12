<template>
  <div class="user-window" :style="viewStyle">
    <div class="user-window-inner">
      <div class="user-window-header">
        <NButton circle quaternary title="返回" @click="emits('cancle')">
          <ArrowLeftIcon size="18px" />
        </NButton>
        <span>{{ title }}</span>
      </div>
      <slot />
      <NButton type="primary" block @click="emits('ok')">确定</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/UserWindow.css'
import { computed } from 'vue'
import { NButton } from 'naive-ui'
import { ArrowLeftIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'UserWindow',
})

interface UserWindowProps {
  visible: boolean
  title?: string
}

const props = withDefaults(defineProps<UserWindowProps>(), {
  visible: false,
  title: '',
})
const emits = defineEmits<{
  (e: 'ok'): void
  (e: 'cancle'): void
}>()
const viewStyle = computed(() => {
  return {
    display: props.visible ? 'flex' : 'none',
  }
})
</script>
