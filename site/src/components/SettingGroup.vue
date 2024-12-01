<template>
  <div class="border-bt">
    <h6 class="text-primary px-3 mt-3 text-base">{{ title }}</h6>
    <slot />
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'SettingGroup',
})

interface SettingGroupProps {
  title?: string
}

const props = defineProps<SettingGroupProps>()
</script>
