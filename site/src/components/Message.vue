<template>
  <Teleport to="body">
    <div class="fixed top-6 z-30 w-full flex flex-col gap-2 items-center h-0">
      <MessageItem
        v-for="m in ms.messages"
        :key="m.i"
        :message="m"
        @close="ms.close"
      />
    </div>
  </Teleport>
</template>

<script setup lang="ts">
import { useMessage } from '@/stores'
import MessageItem from './MessageItem.vue'

defineOptions({
  name: 'Message',
})

const ms = useMessage()
</script>
