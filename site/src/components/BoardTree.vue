<template>
  <div class="board-tree">
    <Spin v-if="isLoading" :size="32" />
    <button v-for="item in data" :key="item.id" class="board-item">
      <IconRight :size="16" />
      <TypographyText>{{ item.name }}</TypographyText>
    </button>
  </div>
</template>

<script setup lang="ts">
import { Spin, TypographyText } from '@arco-design/web-vue'
import { onMounted, ref } from 'vue'
import type { BoardGroups } from '@/types'
import { getBoardGroups } from '@/services'
import '@/style/BoardTree.css'
import { IconRight } from '@arco-design/web-vue/es/icon'

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
