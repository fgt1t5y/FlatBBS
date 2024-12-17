<template>
  <div class="p-3 flex flex-col gap-2 border-bt">
    <div class="flex justify-between items-end">
      <Avatar
        class="size-16 md:size-24"
        :src="avatarUri"
        :rounded="avatarRounded"
      />
    </div>
    <div>
      <div class="text-lg font-bold">
        {{ name }}
      </div>
      <div class="text-base text-muted">{{ introduction }}</div>
    </div>
    <slot />
  </div>
</template>

<script setup lang="ts">
import Avatar from './Avatar.vue'

defineOptions({
  name: 'CommonDetail',
})

interface CommonDetailProps {
  avatarUri?: string
  name?: string
  introduction?: string
  avatarRounded?: boolean
}

const props = defineProps<CommonDetailProps>()
</script>
