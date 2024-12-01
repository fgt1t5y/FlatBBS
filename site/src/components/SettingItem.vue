<template>
  <section class="p-3 flex flex-col gap-2">
    <div>
      <div>{{ title }}</div>
      <div class="text-muted">{{ subtitle }}</div>
    </div>
    <slot />
  </section>
</template>

<script setup lang="ts">
defineOptions({
  name: 'SettingItem',
})

interface SettingItemProps {
  title?: string
  subtitle?: string
}

const props = defineProps<SettingItemProps>()
</script>
