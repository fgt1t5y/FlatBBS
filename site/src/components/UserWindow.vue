<template>
  <div class="user-window" :style="viewStyle">
    <div class="user-window-inner">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/UserWindow.css'
import { computed } from 'vue'

defineOptions({
  name: 'UserWindow',
})

interface UserWindowProps {
  visible: boolean
  width: number
}

const props = withDefaults(defineProps<UserWindowProps>(), {
  visible: false,
  width: 350,
})
const viewStyle = computed(() => {
  return {
    display: props.visible ? 'flex' : 'none',
  }
})
</script>
