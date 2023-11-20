<template>
  <div class="board-detail item">34</div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'

defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  boardId: number
}

const props = defineProps<BoardDetailProps>()

onMounted(() => {
  console.log(props.boardId)
})
</script>
