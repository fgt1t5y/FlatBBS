<template>
  <div class="mobile-nav">
    <RouterLink class="mobile-nav-item" to="/">
      <NIcon :size="24" :component="Home" />
      首页
    </RouterLink>
    <RouterLink class="mobile-nav-item" to="/boards">
      <NIcon :size="24" :component="BrandSafari" />
      版块
    </RouterLink>
    <RouterLink class="mobile-nav-item" to="/search">
      <NIcon :size="24" :component="Search" />
      搜索
    </RouterLink>
    <RouterLink class="mobile-nav-item" to="/people">
      <NAvatar :size="20" :src="user.info?.avatar_uri" round />
      我
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores'
import { NAvatar, NIcon } from 'naive-ui'
import { Home, BrandSafari, Search } from '@vicons/tabler'
import '@/style/NavbarMobile.css'

defineOptions({
  name: 'MobileNavbar',
})

const user = useUserStore()
</script>
