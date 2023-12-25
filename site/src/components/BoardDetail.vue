<template>
  <div v-if="isSuccess" class="board-detail">
    <div class="board-detail-header">
      <NImage :src="getAvatarPath(data?.header_img_uri!)" />
    </div>
    <div class="board-detail-main chunk">
      <div class="board-detail-intro">
        <NAvatar
          class="board-avatar"
          round
          size="large"
          :src="getAvatarPath(data?.avatar_uri!)"
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
          {{ data?.name }}
        </div>
        <NText :depth="3">
          {{ data?.description }}
        </NText>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFetchData, getAvatarPath } from '@/utils'
import { getBoardInfo } from '@/services'
import { onMounted, watch } from 'vue'
import type { Board } from '@/types'
import { NButton, NImage, NAvatar, NText } from 'naive-ui'
import '@/style/BoardDetail.css'
import { EllipsisIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  slug: string
}

const props = defineProps<BoardDetailProps>()
const { isSuccess, data, fetch } = useFetchData<Board>(getBoardInfo)

watch(
  () => props.slug,
  (value) => {
    if (!value) return
    fetch(value)
  },
)

onMounted(() => {
  fetch(props.slug)
})
</script>
