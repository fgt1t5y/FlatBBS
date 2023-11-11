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
        <RouterLink to="/search" class="sider-link link">
          <SearchIcon size="20px" />
          <span>搜索</span>
        </RouterLink>
        <RouterLink to="/people" class="sider-link link">
          <Houses2Icon size="20px" />
          <span>我的空间</span>
        </RouterLink>
        <RouterLink v-if="user.isLogin" to="/settings" class="sider-link link">
          <SettingIcon size="20px" />
          <span>设置</span>
        </RouterLink>
        <RouterLink v-else to="/auth" class="sider-link link">
          <UserIcon size="20px" />
          <span>注册 / 登录</span>
        </RouterLink>
        <NText depth="3" class="sider-group" title="论坛版块列表">
          论坛版块
        </NText>
        <BoardList />
      </div>
    </template>
    <template #content>
      <RouterView v-slot="{ Component }">
        <KeepAlive exclude="SettingsView" :max="10">
          <component :is="Component" />
        </KeepAlive>
      </RouterView>
    </template>
    <template #panels>
      <div class="grid-panels-inner">
        <NInput
          ref="inputRef"
          :max-length="64"
          placeholder="搜索...（^K）"
          size="large"
          round
        />
      </div>
    </template>
  </CommonGrid>
  <div v-if="isMobile" class="mobile-nav">
    <RouterLink class="mobile-nav-item link" to="/">
      <HomeIcon size="20px" />
      首页
    </RouterLink>
    <RouterLink class="mobile-nav-item link" to="/boards">
      <AppIcon size="20px" />
      版块
    </RouterLink>
    <RouterLink class="mobile-nav-item link" to="/search">
      <SearchIcon size="20px" />
      搜索
    </RouterLink>
    <RouterLink class="mobile-nav-item link" to="/people">
      <NAvatar :size="20" :src="user.info.avatar_uri" round />
      我
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import SiteLogo from '@/components/SiteLogo.vue'
import { useUserStore } from '@/stores'
import { isMobile } from '@/utils'
import { NText, NInput, useMessage, NAvatar } from 'naive-ui'
import {
  HomeIcon,
  SearchIcon,
  SettingIcon,
  UserIcon,
  Houses2Icon,
  AppIcon,
} from 'tdesign-icons-vue-next'
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'

const user = useUserStore()
window.$message = useMessage()
const inputRef = ref<InstanceType<typeof NInput>>()
const focusInput = (ev: KeyboardEvent) => {
  if (ev.key === 'k' && ev.ctrlKey) {
    ev.preventDefault()
    inputRef.value?.focus()
  }
}

onMounted(() => {
  document.addEventListener('keydown', focusInput)
})
</script>
