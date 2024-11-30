<template>
  <Navbar v-if="isDesktop" />
  <div id="flatbbs">
    <RouterView v-slot="{ Component, route }">
      <KeepAlive :max="10">
        <component :is="Component" :key="route.fullPath" />
      </KeepAlive>
    </RouterView>
    <NBackTop />
  </div>
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
</template>

<script setup lang="ts">
import { isDesktop } from '@/utils'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import { useMessage, NBackTop } from 'naive-ui'

window.$message = useMessage()
</script>
