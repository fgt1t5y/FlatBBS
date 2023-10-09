<template>
  <section class="settings-field">
    <TypographyText>{{ title }}</TypographyText>
    <TypographyText type="secondary">{{ subtitle }}</TypographyText>
    <slot name="content" />
  </section>
</template>

<script setup lang="ts">
import { TypographyText } from '@arco-design/web-vue'

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

<style>
.settings-field {
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding: 1rem 0px;
  border-top: 1px solid var(--color-neutral-3);
}
</style>
