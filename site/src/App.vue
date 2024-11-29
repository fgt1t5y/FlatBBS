<template>
  <NConfigProvider
    :theme="theme.naiveuiDark ? darkTheme : null"
    :theme-overrides="themeOverrides"
    :locale="zhCN"
  >
    <NDialogProvider>
      <NMessageProvider>
        <RouterView />
        <NGlobalStyle />
      </NMessageProvider>
    </NDialogProvider>
  </NConfigProvider>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import { hasToken } from './utils'
import {
  NMessageProvider,
  NDialogProvider,
  NConfigProvider,
  darkTheme,
  NGlobalStyle,
  zhCN,
} from 'naive-ui'

import type { GlobalThemeOverrides } from 'naive-ui'

const user = useUserStore()
const theme = useTheme()
theme.init()

if (hasToken()) {
  user.fetch()
}

const themeOverrides: GlobalThemeOverrides = {
  common: {
    baseColor: '#FFFFFFFF',
    primaryColor: '#6366F1FF',
    primaryColorHover: '#4F46E5FF',
    primaryColorPressed: '#4338CAFF',
    primaryColorSuppl: '#6366F1FF',
  },
}
</script>
