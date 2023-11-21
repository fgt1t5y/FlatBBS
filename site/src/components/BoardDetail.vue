<template>
  <div v-if="isLoading || isFailed" class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
  </div>
  <div v-else class="board-detail">
    <NImage :src="getAvatarPath(board_info?.header_img_uri!)" />
    <div class="board-info-header item">
      <NAvatar
        class="board-avatar"
        size="large"
        :src="getAvatarPath(board_info?.avatar_uri!)"
      />
      <div class="board-detail-name">
        {{ board_info?.name }}
        <div class="board-detail-desc" :depth="3">
          {{ board_info?.description }}
        </div>
      </div>
      <NButton type="primary" round>加入</NButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFetchData, getAvatarPath } from '@/utils'
import { getBoardInfo } from '@/services'
import { onMounted, ref } from 'vue'
import type { Board } from '@/types'
import { NSpin, NButton, NImage, NAvatar } from 'naive-ui'
import '@/style/BoardDetail.css'

defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  boardId: number
}

const props = defineProps<BoardDetailProps>()
const board_info = ref<Board | undefined>(undefined)
const { isLoading, isFailed, fetch, retry } = useFetchData<Board>(
  getBoardInfo,
  (data) => {
    console.log(data)
    board_info.value = data
  },
)

onMounted(() => {
  fetch(props.boardId)
})
</script>
