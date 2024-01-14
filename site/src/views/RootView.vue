<template>
  <CommonGrid>
    <template #sider>
      <div class="grid-sider-inner">
        <RouterLink to="/" class="site-brand">
          <SiteLogo />
          <NTag v-if="isDev" type="warning" round>Dev</NTag>
        </RouterLink>
        <RouterLink to="/" class="sider-link link">
          <HomeIcon size="20px" />
          <span>首页</span>
        </RouterLink>
        <RouterLink to="/bookmark" class="sider-link link">
          <BookmarkIcon size="20px" />
          <span>书签</span>
        </RouterLink>
        <div v-if="user.isLogin">
          <RouterLink to="/auth" class="sider-link link">
            <NAvatar :size="20" :src="user.info?.avatar_uri" round />
            <span>我的空间</span>
          </RouterLink>
          <NButton
            title="展开或收起菜单"
            quaternary
            round
            block
            @click="isShowExtraMenuItems = !isShowExtraMenuItems"
          >
            <ChevronUpIcon v-if="isShowExtraMenuItems" size="20px" />
            <ChevronDownIcon v-else size="20px" />
          </NButton>
          <RouterLink
            v-if="isShowExtraMenuItems"
            to="/settings"
            class="sider-link link"
          >
            <Setting1Icon size="20px" />
            <span>设置</span>
          </RouterLink>
          <button
            v-if="isShowExtraMenuItems"
            class="sider-link link"
            @click="user.quit"
          >
            <LogoutIcon size="20px" />
            <span>退出登录</span>
          </button>
        </div>
        <div v-else>
          <RouterLink to="/auth" class="sider-link link">
            <LoginIcon size="20px" />
            <span>注册 / 登录</span>
          </RouterLink>
        </div>
        <NText depth="3" class="sider-group" title="论坛版块列表">
          论坛版块
        </NText>
        <SiderBoardList />
      </div>
    </template>
    <template #content>
      <RouterView v-slot="{ Component }">
        <Transition :name="route.meta.transition" :css="!isDesktop">
          <KeepAlive :max="10">
            <component :is="Component" />
          </KeepAlive>
        </Transition>
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
import { isDesktop, isDev } from '@/utils'
import NavbarMobile from '@/components/NavbarMobile.vue'
import { NText, useMessage, NBackTop, NButton, NAvatar, NTag } from 'naive-ui'
import {
  HomeIcon,
  BookmarkIcon,
  LoginIcon,
  ChevronUpIcon,
  ChevronDownIcon,
  Setting1Icon,
  LogoutIcon,
} from 'tdesign-icons-vue-next'
import { RouterLink, useRoute } from 'vue-router'
import { useUserStore } from '@/stores'
import { ref } from 'vue'

const isShowExtraMenuItems = ref<boolean>(false)
const route = useRoute()
const user = useUserStore()
window.$message = useMessage()
</script>
