<template>
  <div class="board-detail item">34</div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  boardId: number
}

const props = defineProps<BoardDetailProps>()
</script>
