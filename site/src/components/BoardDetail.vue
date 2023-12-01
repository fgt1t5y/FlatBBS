<template>
  <div v-if="!isSuccess" class="row-center">
    <NSpin v-if="isLoading" :size="32" />
  </div>
  <div v-else class="board-detail">
    <div class="board-detail-header">
      <NImage :src="getAvatarPath(board_info?.header_img_uri!)" />
    </div>
    <div class="board-detail-main item">
      <div class="board-detail-intro">
        <NAvatar
          class="board-avatar"
          round
          size="large"
          :src="getAvatarPath(board_info?.avatar_uri!)"
        />
        <div class="board-detail-opt">
          <NButton circle secondary>
            <template #icon>
              <EllipsisIcon size="18px" />
            </template>
          </NButton>
          <NButton type="primary" round>加入</NButton>
        </div>
      </div>
      <div class="board-detail-info">
        <div class="board-detail-name">
          {{ board_info?.name }}
        </div>
        <NText :depth="3">
          {{ board_info?.description }}
        </NText>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFetchData, getAvatarPath } from '@/utils'
import { getBoardInfo } from '@/services'
import { onMounted, ref, watch } from 'vue'
import type { Board } from '@/types'
import { NSpin, NButton, NImage, NAvatar, NText } from 'naive-ui'
import '@/style/BoardDetail.css'
import { EllipsisIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  boardId: number
}

const props = defineProps<BoardDetailProps>()
const board_info = ref<Board | undefined>(undefined)
const { isLoading, isSuccess, fetch } = useFetchData<Board>(
  getBoardInfo,
  (data) => {
    board_info.value = data
  },
)

watch(
  () => props.boardId,
  (board_id) => {
    if (!board_id) return
    fetch(board_id)
  },
)

onMounted(() => {
  fetch(props.boardId)
})
</script>
