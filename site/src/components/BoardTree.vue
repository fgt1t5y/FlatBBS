<template>
  <div class="board-tree">
    <Spin v-if="isLoading" :size="32" />
    <BoardTreeNode
      v-for="item in data"
      :key="item.id"
      :group-id="item.id"
      :group-name="item.name"
    />
  </div>
</template>

<script setup lang="ts">
import { Spin } from '@arco-design/web-vue'
import { onMounted, ref } from 'vue'
import type { BoardGroups } from '@/types'
import { getBoardGroups } from '@/services'
import '@/style/BoardTree.css'
import BoardTreeNode from './BoardTreeNode.vue'

defineOptions({
  name: 'BoardTree',
})

const data = ref<BoardGroups[] | null>(null)
const isLoading = ref<boolean>(true)

onMounted(() => {
  getBoardGroups().then((res) => {
    if (res.data.code === 0) {
      data.value = res.data.data!
      isLoading.value = false
    }
  })
})
</script>
