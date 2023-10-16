<template>
  <CommonGrid>
    <template #sider>
      <Button type="primary">新主题</Button>
      <BoardTree />
    </template>
    <template #content>
      <RouterView />
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import BoardTree from '@/components/BoardTree.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import { Button } from '@arco-design/web-vue'
</script>
