<template>
  <section class="settings-field">
    <NSpace vertical :size="0">
      <NText>{{ title }}</NText>
      <NText depth="3">{{ subtitle }}</NText>
    </NSpace>
    <slot />
  </section>
</template>

<script setup lang="ts">
import { NText, NSpace } from 'naive-ui'
import '@/style/SettingItem.css'

defineOptions({
  name: 'SettingItem',
})

interface SettingItemProps {
  title?: string
  subtitle?: string
}

const props = defineProps<SettingItemProps>()
</script>
