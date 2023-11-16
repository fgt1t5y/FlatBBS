<template>
  <div class="board-list">
    <RouterLink
      v-for="i in boards"
      :key="i.id"
      :to="idToUri(i.id, i.name)"
      class="sider-link link"
    >
      <span class="board-dot" :style="{ backgroundColor: i.color }"></span>
      {{ i.name }}
    </RouterLink>
    <div class="row-center">
      <NSpin v-if="isLoading" :size="32" />
      <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { getBoards } from '@/services'
import type { Board } from '@/types'
import { onMounted, ref } from 'vue'
import '@/style/BoardList.css'
import { NSpin, NButton } from 'naive-ui'
import { useFetchData } from '@/utils/useFetchData'

defineOptions({
  name: 'BoardList',
})

const boards = ref<Board[]>([])
const idToUri = (id: number, name: string) => `/board/${id}/${name}`

const { isFailed, isLoading, fetch, retry } = useFetchData<Board[]>(
  getBoards,
  (data) => {
    boards.value.push(...data)
  },
)

onMounted(fetch)
</script>
