<template>
  <div class="site-layout">
    <GlobalSidebar v-if="isDesktop" class="site-layout-sidebar" />
    <RouterView v-slot="{ Component, route }">
      <KeepAlive :max="10">
        <component :is="Component" :key="route.fullPath" />
      </KeepAlive>
    </RouterView>
  </div>
</template>

<script setup lang="ts">
import GlobalSidebar from '@/components/GlobalSidebar.vue'
import { isDesktop } from '@/utils'
</script>
