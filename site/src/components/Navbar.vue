<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <RouterLink to="/" class="navbar-sitename">
        <SiteLogo />
        <NText>FlatBBS</NText>
      </RouterLink>
      <div v-if="isLoggined" class="navbar-options">
        <NButton title="查看通知" quaternary circle>
          <template #icon>
            <NotificationIcon />
          </template>
        </NButton>
        <NAvatar
          :src="user.info.avatar_uri"
          title="你的头像图片"
          :bordered="true"
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
import { NText, NButton, NAvatar } from 'naive-ui'
import { useUserStore } from '@/stores'
import { NotificationIcon } from 'tdesign-icons-vue-next'

defineOptions({
  name: 'Navbar',
})

interface NavbarProps {
  isLoggined: boolean
}

const props = defineProps<NavbarProps>()
const user = useUserStore()
</script>
