<template>
  <CommonGrid>
    <template #sider>
      <Button type="primary">新主题</Button>
      <RouterLink to="/brand">
        <a href="#">版块</a>
      </RouterLink>
    </template>
    <template #content>
      <RouterView />
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from '@/components/CommonGrid.vue'
import { Button } from '@arco-design/web-vue'
</script>
