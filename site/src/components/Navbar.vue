<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <RouterLink to="/" class="navbar-sitename">
        <SiteLogo />
        <NText>FlatBBS</NText>
      </RouterLink>
      <div v-if="isLoggined" class="navbar-options">
        <NButton type="primary" round>OK</NButton>
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
import { NText, NButton } from 'naive-ui'

defineOptions({
  name: 'Navbar',
})

interface NavbarProps {
  isLoggined: boolean
}

const props = defineProps<NavbarProps>()
</script>
