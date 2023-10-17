<template>
  <CommonGrid>
    <template #sider>
      <Button type="primary">新主题</Button>
      <Divider :margin="12" />
      <div class="sider-menu">23</div>
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
import { Button, Divider } from '@arco-design/web-vue'
</script>
