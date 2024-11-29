<template>
  <div v-if="loading" class="row-center">
    <NSpin :size="32" />
  </div>
  <div v-else class="board-list">
    <RouterLink
      v-for="i in data.data"
      :key="i.id"
      :to="`/board/${i.slug}`"
      class="sider-link link"
    >
      <span class="board-dot" :style="{ backgroundColor: i.color }"></span>
      {{ i.name }}
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import { getBoards } from '@/services'
import { NSpin } from 'naive-ui'
import { useRequest } from 'alova'

defineOptions({
  name: 'SiderBoardList',
})

const { data, loading } = useRequest(getBoards)
</script>
