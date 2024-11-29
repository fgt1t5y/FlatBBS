<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <RouterLink to="/" class="navbar-sitename">
        <NText>FlatBBS</NText>
      </RouterLink>
      <div v-if="user.isLogin && user.info" class="navbar-options">
        <NPopover
          placement="bottom-end"
          trigger="click"
          content-class="user-panel"
        >
          <template #trigger>
            <NAvatar
              :src="user.info.avatar_uri"
              :title="user.info.display_name"
              round
            />
          </template>
          <div class="user-panel-info">
            <b>{{ user.info.display_name }}</b>
            <NText :depth="3">@{{ user.info.username }}</NText>
            <RouterLink to="/settings">
              <NButton secondary round block>设置</NButton>
            </RouterLink>
            <NButton type="error" secondary round block @click="user.quit">
              退出登录
            </NButton>
          </div>
        </NPopover>
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
import { NText, NButton, NAvatar, NPopover } from 'naive-ui'
import { useUserStore } from '@/stores'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
</script>
