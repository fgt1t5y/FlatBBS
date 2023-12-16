<template>
  <div class="mobile-nav">
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
      <NAvatar :size="20" :src="getAvatarPath(user.info?.avatar_uri!)" round />
      我
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores'
import { NAvatar } from 'naive-ui'
import { HomeIcon, AppIcon, SearchIcon } from 'tdesign-icons-vue-next'
import '@/style/NavbarMobile.css'
import { getAvatarPath } from '@/utils'

defineOptions({
  name: 'MobileNavbar',
})

const user = useUserStore()
</script>
