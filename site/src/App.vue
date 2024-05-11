<template>
  <NConfigProvider :theme="theme.naiveuiDark ? darkTheme : null" :locale="zhCN" abstract>
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

const user = useUserStore()
const theme = useTheme()
theme.init()

if (hasToken()) {
  user.fetch()
}
</script>
