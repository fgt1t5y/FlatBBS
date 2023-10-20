<template>
  <div class="board-list">
    <RouterLink
      v-for="i in boards"
      :key="i.id"
      :to="idToUri(i.id)"
      class="sider-link link"
    >
      <span class="board-dot" :style="{ backgroundColor: i.color }"></span>
      {{ i.name }}
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import { getBoards } from '@/services'
import type { Board } from '@/types'
import { onMounted, ref } from 'vue'
import '@/style/BoardList.css'

defineOptions({
  name: 'BoardList',
})

const boards = ref<Board[] | null>(null)
const idToUri = (id: number) => {
  return '/board/' + String(id)
}

onMounted(() => {
  getBoards().then((res) => {
    if (res.data.code === 0) {
      boards.value = res.data.data!
    }
  })
})
</script>
