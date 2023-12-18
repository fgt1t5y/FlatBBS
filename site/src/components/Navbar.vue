<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <RouterLink to="/" class="navbar-sitename">
        <SiteLogo />
        <NText>FlatBBS</NText>
        <NTag v-if="isDev" type="warning" round>Dev</NTag>
      </RouterLink>
      <div v-if="isLoggined" class="navbar-options">
        <NButton title="发布新话题" quaternary circle>
          <template #icon>
            <AddRectangleIcon />
          </template>
        </NButton>
        <NButton
          title="设置"
          quaternary
          circle
          @click="router.push({ path: '/settings' })"
        >
          <template #icon>
            <Setting1Icon />
          </template>
        </NButton>
        <NButton title="查看通知" quaternary circle>
          <template #icon>
            <NotificationIcon />
          </template>
        </NButton>
        <NAvatar
          :src="user.info?.avatar_uri"
          title="你的头像图片，点击打开菜单"
          round
        />
      </div>
      <div v-else class="navbar-options">
        <NButton type="primary" round>注册 / 登录</NButton>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import '@/style/Navbar.css'
import SiteLogo from './SiteLogo.vue'
import { NText, NButton, NAvatar, NTag } from 'naive-ui'
import { useUserStore } from '@/stores'
import {
  NotificationIcon,
  AddRectangleIcon,
  Setting1Icon,
} from 'tdesign-icons-vue-next'
import { isDev } from '@/utils'
import router from '@/router'

defineOptions({
  name: 'Navbar',
})

interface NavbarProps {
  isLoggined: boolean
}

const props = defineProps<NavbarProps>()
const user = useUserStore()
</script>
