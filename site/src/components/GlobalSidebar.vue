<template>
  <aside id="sidebar" class="sidebar">
    <RouterLink class="menu-item sidebar-menu-item" :to="{ name: 'home' }">
      <Home class="size-5" />
      <span>{{ $t('page.home') }}</span>
    </RouterLink>
    <RouterLink
      class="menu-item sidebar-menu-item"
      :to="{ name: 'board_list' }"
    >
      <Flower class="size-5" />
      <span>{{ $t('page.boards') }}</span>
    </RouterLink>
    <RouterLink
      class="menu-item sidebar-menu-item"
      :to="{ name: 'logs' }"
    >
      <Clock class="size-5" />
      <span>{{ $t('page.visit_logs') }}</span>
    </RouterLink>
  </aside>
</template>

<script setup lang="ts">
import { Home, Flower, Clock } from '@vicons/tabler'

defineOptions({
  name: 'GlobalSidebar',
})
</script>
