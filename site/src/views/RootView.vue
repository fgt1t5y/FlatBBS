<template>
  <CommonGrid>
    <template #sider>
      <div class="grid-sider-inner">
        <RouterLink to="/" class="site-brand">
          <SiteLogo />
        </RouterLink>
        <RouterLink to="/" class="sider-link link">
          <HomeIcon size="20px" />
          <span>首页</span>
        </RouterLink>
        <RouterLink to="/bookmark" class="sider-link link">
          <BookmarkIcon size="20px" />
          <span>书签</span>
        </RouterLink>
        <RouterLink to="/publish" class="sider-link link">
          <AddIcon size="20px" />
          <span>发布</span>
        </RouterLink>
        <NText depth="3" class="sider-group" title="论坛版块列表">
          论坛版块
        </NText>
        <SiderBoardList />
      </div>
    </template>
    <template #content>
      <RouterView v-slot="{ Component }">
        <KeepAlive exclude="SettingsView" :max="10">
          <component :is="Component" />
        </KeepAlive>
      </RouterView>
    </template>
  </CommonGrid>
  <NBackTop />
  <NavbarMobile v-if="!isDesktop && route.meta.showBottomNav" />
</template>

<script setup lang="ts">
import SiderBoardList from '@/components/SiderBoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import SiteLogo from '@/components/SiteLogo.vue'
import { isDesktop } from '@/utils'
import NavbarMobile from '@/components/NavbarMobile.vue'
import { NText, useMessage, NBackTop } from 'naive-ui'
import { HomeIcon, BookmarkIcon, AddIcon } from 'tdesign-icons-vue-next'
import { RouterLink, useRoute } from 'vue-router'

const route = useRoute()
window.$message = useMessage()
</script>
