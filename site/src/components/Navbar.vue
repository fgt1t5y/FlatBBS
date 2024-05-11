<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <RouterLink to="/" class="navbar-sitename">
        <NText>FlatBBS</NText>
      </RouterLink>
      <div v-if="isDesktop" class="navbar-search">
        <NInput placeholder="搜索..." :input-props="{ type: 'search' }" round />
      </div>
      <div v-if="user.isLogin" class="navbar-options">
        <NButton title="发布新话题" quaternary circle>
          <AddRectangleIcon />
        </NButton>
        <RouterLink to="/settings">
          <NButton title="设置" quaternary circle>
            <Setting1Icon />
          </NButton>
        </RouterLink>
        <NButton title="查看通知" quaternary circle>
          <NotificationIcon />
        </NButton>
        <NAvatar
          :src="user.info?.avatar_uri"
          title="你的头像图片，点击打开菜单"
          round
        />
      </div>
      <div v-else class="navbar-options">
        <RouterLink to="/auth">
          <NButton type="primary" round>注册 / 登录</NButton>
        </RouterLink>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import '@/style/Navbar.css'
import { NText, NButton, NAvatar, NInput } from 'naive-ui'
import { useUserStore } from '@/stores'
import {
  NotificationIcon,
  AddRectangleIcon,
  Setting1Icon,
} from 'tdesign-icons-vue-next'
import { isDesktop } from '@/utils'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
</script>
