<template>
  <NConfigProvider :theme="theme.naiveuiDark ? darkTheme : null" :locale="zhCN">
    <NDialogProvider>
      <NMessageProvider>
        <Navbar v-if="isDesktop" :is-loggined="user.isLogin" />
        <div id="flatbbs">
          <CommonGrid>
            <RouterView v-slot="{ Component }">
              <KeepAlive :max="10">
                <component :is="Component" />
              </KeepAlive>
            </RouterView>
          </CommonGrid>
          <NBackTop />
        </div>
        <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
        <NGlobalStyle />
      </NMessageProvider>
    </NDialogProvider>
  </NConfigProvider>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import { hasToken, isDesktop } from './utils'
import {
  NMessageProvider,
  NDialogProvider,
  NConfigProvider,
  darkTheme,
  NGlobalStyle,
  zhCN,
  NBackTop,
} from 'naive-ui'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import CommonGrid from '@/components/CommonGrid.vue'

const user = useUserStore()
const theme = useTheme()
theme.init()

if (hasToken()) {
  user.fetch()
}
</script>
