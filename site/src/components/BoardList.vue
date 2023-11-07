<template>
  <div class="board-list">
    <div v-if="isFailed" class="row-center">
      <NButton type="primary" @click="fetchBoards">重试</NButton>
    </div>
    <NSpin v-if="isLoading" :size="32" description="加载..." />
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
import { NSpin, NButton } from 'naive-ui'

defineOptions({
  name: 'BoardList',
})

const boards = ref<Board[] | null>(null)
const idToUri = (id: number) => '/board/' + String(id)
const isLoading = ref<boolean>(false)
const isFailed = ref<boolean>(false)

const fetchBoards = () => {
  isLoading.value = true
  isFailed.value = false
  getBoards()
    .then((res) => {
      if (res.data.code === window.$code.OK) {
        boards.value = res.data.data!
      }
    })
    .catch(() => {
      isFailed.value = true
    })
    .finally(() => {
      isLoading.value = false
    })
}

onMounted(() => {
  fetchBoards()
})
</script>
