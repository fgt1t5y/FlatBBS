<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/" class="sider-link link">
        <IconHome />
        <span>首页</span>
      </RouterLink>
      <Divider :margin="12" />
      <TypographyText type="secondary" class="sider-group">
        论坛版块
      </TypographyText>
      <BoardList />
    </template>
    <template #content>
      <RouterView />
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import { Divider, TypographyText } from '@arco-design/web-vue'
import { IconHome } from '@arco-design/web-vue/es/icon'
import { RouterLink } from 'vue-router'
</script>

