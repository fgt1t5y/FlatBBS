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
    <div class="row-center">
      <NSpin v-if="isLoading" :size="32" />
      <NButton v-if="isFailed" type="primary" @click="fetchBoards">
        重试
      </NButton>
    </div>
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
