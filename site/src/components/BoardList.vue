<template>
  <div class="board-list">
    <div v-if="isLoading" class="align-center">
      <Spin :size="32" />
    </div>
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
import { Spin } from '@arco-design/web-vue'

defineOptions({
  name: 'BoardList',
})

const boards = ref<Board[] | null>(null)
const idToUri = (id: number) => '/board/' + String(id)
const isLoading = ref<boolean>(true)

onMounted(() => {
  getBoards().then((res) => {
    if (res.data.code === 0) {
      boards.value = res.data.data!
      isLoading.value = false
    }
  })
})
</script>
