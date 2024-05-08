<template>
  <div class="common-detail">
    <NImage :img-props="{ id: 'common-header-img' }" :src="headerImageUri" />
    <div class="common-detail-main chunk">
      <div class="common-detail-intro">
        <NAvatar class="common-avatar" round size="large" :src="avatarUri" />
        <div class="common-detail-opt">
          <NButton circle secondary>
            <template #icon>
              <EllipsisIcon />
            </template>
          </NButton>
          <NButton type="primary" round>加入</NButton>
        </div>
      </div>
      <div class="common-detail-info">
        <div class="common-detail-name">
          {{ name }}
        </div>
        <NText :depth="3">
          {{ introduction }}
        </NText>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { NButton, NImage, NAvatar, NText } from 'naive-ui'
import '@/style/CommonDetail.css'
import { EllipsisIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'CommonDetail',
})

interface CommonDetailProps {
  avatarUri: string
  headerImageUri?: string
  name: string
  introduction?: string
}

const props = defineProps<CommonDetailProps>()
</script>
