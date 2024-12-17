<template>
  <div class="border-bt">
    <div class="p-3 flex flex-col gap-2">
      <div class="flex justify-between items-end">
        <Avatar class="size-24" :src="avatarUri" :rounded="avatarRounded" />
        <slot />
      </div>
      <div>
        <div class="text-lg font-bold">
          {{ name }}
        </div>
        <div class="text-muted">{{ introduction }}</div>
      </div>
    </div>
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
