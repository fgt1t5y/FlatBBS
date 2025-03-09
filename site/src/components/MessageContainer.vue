<template>
  <div class="message-container" aria-hidden="true">
    <TransitionGroup>
      <MessageItem
        v-for="m in ms.messages"
        :key="m.i"
        :message="m"
        @close="ms.close"
      />
    </TransitionGroup>
  </div>
</template>

<script setup lang="ts">
import { useMessage } from '@/stores'
import MessageItem from './MessageItem.vue'

defineOptions({
  name: 'MessageContainer',
})

const ms = useMessage()
</script>
