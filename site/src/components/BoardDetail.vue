<template>
  <div v-if="!loading" class="board-detail">
    <NImage
      :img-props="{ id: 'board-header-img' }"
      :src="data?.header_img_uri"
    />
    <div class="board-detail-main chunk">
      <div class="board-detail-intro">
        <NAvatar
          class="board-avatar"
          round
          size="large"
          :src="data?.avatar_uri"
        />
        <div class="board-detail-opt">
          <NButton circle secondary>
            <template #icon>
              <EllipsisIcon />
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
import { useTitle } from '@/utils'
import { getBoardInfo } from '@/services'
import { NButton, NImage, NAvatar, NText } from 'naive-ui'
import '@/style/BoardDetail.css'
import { EllipsisIcon } from 'tdesign-icons-vue-next'
import { useWatcher } from 'alova'

defineOptions({
  name: 'BoardDetail',
})

interface BoardDetailProps {
  slug: string
}

const props = defineProps<BoardDetailProps>()

const { setTitle } = useTitle('版块')

const { loading, data, onSuccess } = useWatcher(
  () => getBoardInfo(props.slug),
  [props],
  {
    immediate: true,
    sendable: () => !!props.slug,
  },
)

onSuccess(() => {
  setTitle(data.value.name)
})
</script>
