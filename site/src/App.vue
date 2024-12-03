<template>
  <Navbar v-if="isDesktop" />
  <div id="flatbbs" class="flex gap-3">
    <RouterView v-slot="{ Component, route }">
      <KeepAlive :max="10">
        <component :is="Component" :key="route.fullPath" />
      </KeepAlive>
    </RouterView>
  </div>
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
  <Message />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import { hasToken } from './utils'
import { isDesktop } from '@/utils'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import Message from '@/components/Message.vue'

const user = useUserStore()
const theme = useTheme()
theme.init()

if (hasToken()) {
  user.fetch()
}
</script>
