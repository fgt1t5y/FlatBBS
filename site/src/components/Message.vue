<template>
  <Teleport to="body">
    <div class="message-container">
      <TransitionGroup>
        <MessageItem
          v-for="m in ms.messages"
          :key="m.i"
          :message="m"
          @close="ms.close"
        />
      </TransitionGroup>
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
