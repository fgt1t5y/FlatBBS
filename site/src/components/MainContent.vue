<template>
  <div class="grid-main-content">
    <slot />
  </div>
  <div v-if="isDesktop" class="grid-main-panels">
    <div class="grid-main-panels-inner">
      <NButton size="large" round block>
        <template #icon>
          <SearchIcon />
        </template>
        搜索
      </NButton>
      <slot name="panels" />
      <footer>
        <NText :depth="3">
          此站点由
          <NA href="https://github.com/fgt1t5y/FlatBBS" target="_blank">
            FlatBBS
          </NA>
          驱动
        </NText>
      </footer>
    </div>
  </div>
</template>

<script setup lang="ts">
import { isDesktop } from '@/utils'
import { NText, NA, NButton } from 'naive-ui'
import { SearchIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'MainContent',
})
</script>
