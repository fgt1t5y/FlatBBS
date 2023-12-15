<template>
  <NModal v-model:show="s.showSearchPanel" transform-origin="center">
    <NCard class="search-panel" size="small">
      <NInput size="large" placeholder="搜索版块、话题或用户..." />
    </NCard>
  </NModal>
</template>

<script setup lang="ts">
import { NModal, NCard, NInput } from 'naive-ui'
import '@/style/SearchPanel.css'
import { useStateStore } from '@/stores'

defineOptions({
  name: 'SearchPanel',
})

const s = useStateStore()
</script>
