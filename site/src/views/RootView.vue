<template>
  <CommonGrid>
    <template #sider>
      <div v-if="isDesktop" class="grid-sider-inner">
        <RouterLink to="/" class="site-brand">
          <SiteLogo />
        </RouterLink>
        <RouterLink to="/" class="sider-link link">
          <HomeIcon size="20px" />
          <span>首页</span>
        </RouterLink>
        <RouterLink to="/notification" class="sider-link link">
          <NotificationIcon size="20px" />
          <span>通知</span>
        </RouterLink>
        <RouterLink to="/bookmark" class="sider-link link">
          <BookmarkIcon size="20px" />
          <span>书签</span>
        </RouterLink>
        <RouterLink to="/people" class="sider-link link">
          <Houses2Icon size="20px" />
          <span>我的空间</span>
        </RouterLink>
        <NPopover v-if="user.isLogin" trigger="click" placement="bottom-start">
          <template #trigger>
            <button class="sider-link link">
              <NAvatar :size="18" :src="user.info.avatar_uri" round />
              <span>{{ user.info.username }}</span>
              <EllipsisIcon size="18px" />
            </button>
          </template>
          <RouterLink to="/settings" class="sider-link link">
            <SettingIcon size="20px" />
            <span>设置</span>
          </RouterLink>
          <button class="sider-link link" @click="user.quit">
            <LogoutIcon size="20px" />
            <span>退出登录</span>
          </button>
        </NPopover>
        <RouterLink v-else to="/auth" class="sider-link link">
          <LoginIcon size="20px" />
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
      <div v-if="isDesktop" class="grid-panels-inner">
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
  <BottomNav v-if="!isDesktop" />
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import SiteLogo from '@/components/SiteLogo.vue'
import { useUserStore } from '@/stores'
import { isDesktop } from '@/utils'
import BottomNav from '@/components/BottomNav.vue'
import { NText, NInput, useMessage, NAvatar, NPopover } from 'naive-ui'
import {
  HomeIcon,
  Houses2Icon,
  NotificationIcon,
  BookmarkIcon,
  EllipsisIcon,
  SettingIcon,
  LogoutIcon,
  LoginIcon,
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
