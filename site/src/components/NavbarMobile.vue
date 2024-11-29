<template>
  <NEl tag="div" class="mobile-nav">
    <RouterLink class="mobile-nav-item" to="/">首页</RouterLink>
    <RouterLink class="mobile-nav-item" to="/boards">版块</RouterLink>
    <RouterLink class="mobile-nav-item" to="/search">搜索</RouterLink>
    <RouterLink class="mobile-nav-item" to="/people">我</RouterLink>
  </NEl>
</template>

<script setup lang="ts">
import { NEl } from 'naive-ui'

defineOptions({
  name: 'MobileNavbar',
})
</script>
