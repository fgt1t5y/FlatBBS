<template>
  <NConfigProvider
    :theme="theme.naiveuiDark ? darkTheme : null"
    :theme-overrides="overrideTheme"
  >
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
import { hasToken } from './utils'
import {
  NMessageProvider,
  NDialogProvider,
  NConfigProvider,
  darkTheme,
  NGlobalStyle,
} from 'naive-ui'

const user = useUserStore()
const theme = useTheme()
const overrideTheme = {
  List: {
    color: 'rgba(255, 255, 255, 0)',
  },
}

if (hasToken()) {
  user.fetch()
}
</script>
