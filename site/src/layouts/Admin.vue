<template>
  <MainContent reverse-panel>
    <template #panels>
      <div class="p-3 flex flex-col">
        <span class="mb-2 text-muted">Manage</span>
        <RouterLink class="route menu-item" :to="{ name: 'admin_home' }">
          <Home class="size-5" />
          <span>Home</span>
        </RouterLink>
      </div>
    </template>
    <RouterView />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import { Home } from '@vicons/tabler'
</script>
