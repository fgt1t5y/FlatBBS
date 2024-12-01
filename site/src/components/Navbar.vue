<template>
  <nav
    class="z-10 flex justify-center sticky top-0 shadow-md px-3 py-1 bg-white dark:bg-navdark"
  >
    <div class="flex justify-between items-center grow">
      <RouterLink to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
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
          <div class="flex flex-col gap-2">
            <div class="text-base">
              <b>{{ user.info.display_name }}</b>
              <span class="text-muted">@{{ user.info.username }}</span>
            </div>
            <RouterLink to="/settings">
              <NButton secondary round block>设置</NButton>
            </RouterLink>
            <NButton type="error" secondary round block @click="user.quit">
              退出登录
            </NButton>
          </div>
        </NPopover>
      </div>
      <div v-else>
        <RouterLink to="/auth">
          <NButton type="primary" round>注册 / 登录</NButton>
        </RouterLink>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { NButton, NAvatar, NPopover } from 'naive-ui'
import { useUserStore } from '@/stores'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
</script>
