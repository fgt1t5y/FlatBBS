<template>
  <section class="settings-field">
    <Space direction="vertical" :size="0">
      <TypographyText>{{ title }}</TypographyText>
      <TypographyText type="secondary">{{ subtitle }}</TypographyText>
    </Space>
    <slot name="content" />
  </section>
</template>

<script setup lang="ts">
import { TypographyText, Space } from '@arco-design/web-vue'
import '@/style/SettingField.css'

defineOptions({
  name: 'SettingField',
})

interface SettingFieldProps {
  title?: string
  subtitle?: string
}

const props = withDefaults(defineProps<SettingFieldProps>(), {
  title: '',
  subtitle: '',
})
</script>
