<template>
  <div class="grid-content">
    <slot />
  </div>
  <div v-if="isDesktop" class="grid-panels">
    <div class="grid-panels-inner">
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
import { NText, NA } from 'naive-ui'

defineOptions({
  name: 'MainContent',
})
</script>
