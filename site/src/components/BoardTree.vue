<template>
  <div class="board-tree">
    <TypographyText>论坛版块组</TypographyText>
    <Spin v-if="isLoading" :size="32" />
    <div>
      <button v-for="item in data" :key="item.id" class="icon-link">
        {{ item.name }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Spin, TypographyText } from '@arco-design/web-vue'
import { onMounted, ref } from 'vue'
import type { BoardGroups } from '@/types'
import { getBoardGroups } from '@/services'

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
