<template>
  <aside id="sidebar" class="sidebar">
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'home' }">
      <i class="ti ti-home icon"></i>
      <span>{{ $t('page.home') }}</span>
    </RouterLink>
    <RouterLink
      class="menu-item sidebar-menu-item"
      :to="{ name: 'board_list' }"
    >
      <i class="ti ti-flower icon"></i>
      <span>{{ $t('page.boards') }}</span>
    </RouterLink>
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'logs' }">
      <i class="ti ti-clock icon"></i>
      <span>{{ $t('page.visit_logs') }}</span>
    </RouterLink>
  </aside>
</template>

<script setup lang="ts">
defineOptions({
  name: 'GlobalSidebar',
})
</script>
