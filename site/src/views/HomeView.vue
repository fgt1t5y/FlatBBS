<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/" class="sider-link">
        <IconHome />
        <span>所有帖子</span>
      </RouterLink>
      <Divider :margin="12" />
      <TypographyText type="secondary">论坛版块</TypographyText>
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
import { Divider, TypographyText } from '@arco-design/web-vue'
import { IconHome } from '@arco-design/web-vue/es/icon'
import { RouterLink } from 'vue-router'
</script>
