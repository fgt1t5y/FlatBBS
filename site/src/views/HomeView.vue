<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/" class="sider-link">
        <IconHome />
        首页
      </RouterLink>
      <Divider :margin="12" />
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
import { Divider } from '@arco-design/web-vue'
import { IconHome } from '@arco-design/web-vue/es/icon'
import { RouterLink } from 'vue-router'
</script>
