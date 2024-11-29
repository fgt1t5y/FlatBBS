<template>
  <div class="common-detail border-b">
    <div class="common-detail-main chunk">
      <div class="common-detail-intro">
        <NAvatar class="common-avatar" round size="large" :src="avatarUri" />
        <div class="common-detail-opt">
          <NButton circle secondary>
            <template #icon>
              <Dots />
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
import { NButton, NAvatar, NText } from 'naive-ui'
import { Dots } from '@vicons/tabler'

defineOptions({
  name: 'CommonDetail',
})

interface CommonDetailProps {
  avatarUri: string
  name: string
  introduction?: string
}

const props = defineProps<CommonDetailProps>()
</script>
