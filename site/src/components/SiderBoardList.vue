<template>
  <div class="board-list">
    <RouterLink
      v-for="i in data"
      :key="i.id"
      :to="idToUri(i.id, i.name)"
      class="sider-link link"
    >
      <span class="board-dot" :style="{ backgroundColor: i.color }"></span>
      {{ i.name }}
    </RouterLink>
    <div class="row-center">
      <NSpin v-if="isLoading" :size="32" />
      <NButton v-if="isFailed" type="primary" @click="fetch(false)">
        重试
      </NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { getBoards } from '@/services'
import type { Board } from '@/types'
import { onMounted } from 'vue'
import '@/style/SiderBoardList.css'
import { NSpin, NButton } from 'naive-ui'
import { useFetchList } from '@/utils'

defineOptions({
  name: 'SiderBoardList',
})

const idToUri = (id: number, name: string) => `/board/${id}/${name}`

const { isFailed, isLoading, data, fetch } = useFetchList<Board>(getBoards)

onMounted(fetch)
</script>
