<template>
  <aside id="sidebar" class="sidebar">
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'home' }">
      <i class="icon ti ti-home"></i>
      <span>{{ $t('page.home') }}</span>
    </RouterLink>
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'search' }">
      <i class="icon ti ti-search"></i>
      <span>{{ $t('page.search') }}</span>
    </RouterLink>
    <RouterLink
      class="menu-item sidebar-menu-item"
      :to="{ name: 'board_list' }"
    >
      <i class="icon ti ti-flower"></i>
      <span>{{ $t('page.boards') }}</span>
    </RouterLink>
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'logs' }">
      <i class="icon ti ti-clock"></i>
      <span>{{ $t('page.visit_logs') }}</span>
    </RouterLink>
  </aside>
</template>

<script setup lang="ts">
defineOptions({
  name: 'GlobalSidebar',
})
</script>
