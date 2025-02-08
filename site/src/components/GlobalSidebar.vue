<template>
  <aside id="sidebar" class="sidebar">
    <RouterLink class="route menu-item" :to="{ name: 'home' }">
      <Home class="size-5" />
      <span>{{ $t('page.home') }}</span>
    </RouterLink>
    <RouterLink class="route menu-item" :to="{ name: 'board_list' }">
      <Flower class="size-5" />
      <span>{{ $t('page.boards') }}</span>
    </RouterLink>
  </aside>
</template>

<script setup lang="ts">
import { Home, Flower } from '@vicons/tabler'

defineOptions({
  name: 'GlobalSidebar',
})
</script>
