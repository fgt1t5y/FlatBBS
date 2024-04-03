<template>
  <NConfigProvider
    :theme="theme.naiveuiDark ? darkTheme : null"
    :theme-overrides="overrideTheme"
    :locale="zhCN"
  >
    <Navbar v-if="isDesktop" :is-loggined="user.isLogin" />
    <main id="flatbbs">
      <NDialogProvider>
        <NMessageProvider>
          <RouterView />
          <NGlobalStyle />
        </NMessageProvider>
      </NDialogProvider>
    </main>
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
} from 'naive-ui'
import Navbar from './components/Navbar.vue'

const user = useUserStore()
const theme = useTheme()
theme.init()
const overrideTheme = {
  common: {
    cubicBezierEaseInOut: 'none',
    cubicBezierEaseOut: 'none',
    cubicBezierEaseIn: 'none',
  },
}

if (hasToken()) {
  user.fetch()
}
</script>
