<template>
  <div class="emoji-list">
    <span v-for="i in emojis" class="emoji-item">{{ i }}</span>
  </div>
</template>

<script setup lang="ts">
import '@/style/EmojiList.css'

defineOptions({
  name: 'EmojiList',
})

const emojis = [
  '🤔',
  '👋',
  '🤣',
  '😂',
  '😍',
  '😒',
  '😉',
  '😌',
  '😔',
  '😪',
  '🤤',
  '😴',
  '🤭',
  '😗',
]
</script>
