<template>
  <section class="settings-field">
    <Space direction="vertical" :size="0">
      <TypographyText>{{ title }}</TypographyText>
      <TypographyText type="secondary">{{ subtitle }}</TypographyText>
    </Space>
    <slot />
  </section>
</template>

<script setup lang="ts">
import { TypographyText, Space } from '@arco-design/web-vue'
import './SettingItem.css'

defineOptions({
  name: 'SettingItem',
})

interface SettingItemProps {
  title?: string
  subtitle?: string
}

const props = withDefaults(defineProps<SettingItemProps>(), {
  title: '',
  subtitle: '',
})
</script>
