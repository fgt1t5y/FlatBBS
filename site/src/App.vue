<template>
  <main id="flatbbs">
    <NDialogProvider>
      <NMessageProvider>
        <RouterView />
      </NMessageProvider>
    </NDialogProvider>
  </main>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import { hasToken } from './utils'
import { NMessageProvider, NDialogProvider } from 'naive-ui'

const user = useUserStore()
useTheme()

if (hasToken()) {
  user.fetch()
}
</script>
