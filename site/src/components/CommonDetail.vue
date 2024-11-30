<template>
  <div class="border-b">
    <div class="chunk flex flex-col gap-2">
      <div class="flex justify-between items-end">
        <NAvatar class="size-24" :src="avatarUri" />
        <div class="flex gap-2">
          <NButton type="primary" round>加入</NButton>
        </div>
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
import { NButton, NAvatar } from 'naive-ui'

defineOptions({
  name: 'CommonDetail',
})

interface CommonDetailProps {
  avatarUri: string
  name: string
  introduction?: string
}

const props = defineProps<CommonDetailProps>()
</script>
