<template>
  <div class="setting-group">
    <NH6>
      <NText type="primary">{{ title }}</NText>
    </NH6>
    <slot />
  </div>
</template>

<script setup lang="ts">
import { NText, NH6 } from 'naive-ui'
import '@/style/SettingGroup.css'

defineOptions({
  name: 'SettingGroup',
})

interface SettingGroupProps {
  title?: string
}

const props = defineProps<SettingGroupProps>()
</script>
