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
          <NIcon :size="24" :component="Plus" />
        </NButton>
        <RouterLink to="/settings">
          <NButton title="设置" quaternary circle>
            <NIcon :size="24" :component="Settings" />
          </NButton>
        </RouterLink>
        <NButton title="查看通知" quaternary circle>
          <NIcon :size="24" :component="Bell" />
        </NButton>
        <NPopover
          placement="bottom-end"
          trigger="manual"
          content-class="user-panel"
          :show="showUserPanel"
          @clickoutside="showUserPanel = false"
        >
          <template #trigger>
            <NAvatar
              :src="user.info?.avatar_uri"
              :title="user.info?.display_name"
              round
              style="cursor: pointer"
              @click="showUserPanel = true"
            />
          </template>
          <div class="user-panel-info">
            <b>{{ user.info?.display_name }}</b>
            <NText :depth="3">@{{ user.info?.username }}</NText>
          </div>
          <div>
            <NButton type="error" secondary round block @click="user.quit">
              <NIcon :size="24" :component="Logout" />
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
import { NText, NButton, NAvatar, NInput, NPopover, NIcon } from 'naive-ui'
import { useUserStore } from '@/stores'
import { Plus, Bell, Settings, Logout } from '@vicons/tabler'
import { isDesktop } from '@/utils'
import { ref } from 'vue'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
const showUserPanel = ref<boolean>(false)
</script>
