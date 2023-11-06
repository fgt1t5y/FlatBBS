<template>
  <NConfigProvider :theme="theme.naiveuiDark ? darkTheme : null">
    <main id="flatbbs">
      <NDialogProvider>
        <NMessageProvider>
          <RouterView />
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
} from 'naive-ui'

const user = useUserStore()
const theme = useTheme()

if (hasToken()) {
  user.fetch()
}
</script>
