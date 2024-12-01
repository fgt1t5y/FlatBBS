<template>
  <div class="mobile-nav border-tp bg-white dark:bg-navdark">
    <RouterLink class="text-lg route" to="/">首页</RouterLink>
    <RouterLink class="text-lg route" to="/boards">版块</RouterLink>
    <RouterLink class="text-lg route" to="/search">搜索</RouterLink>
    <RouterLink class="text-lg route" to="/people">我</RouterLink>
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'MobileNavbar',
})
</script>
