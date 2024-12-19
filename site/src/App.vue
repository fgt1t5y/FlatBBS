<template>
  <Navbar v-if="isDesktop" />
  <RouterView v-slot="{ Component, route }">
    <KeepAlive :max="10">
      <component :is="Component" :key="route.fullPath" />
    </KeepAlive>
  </RouterView>
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
  <Message />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import { getOrSet, hasToken, set } from './utils'
import { isDesktop } from '@/utils'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import Message from '@/components/Message.vue'
import { useI18n } from 'vue-i18n'
import { languageAliasMap } from './i18n'
import { watch } from 'vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import LocalizedFormat from 'dayjs/plugin/localizedFormat'

const user = useUserStore()
const theme = useTheme()
theme.init()

if (hasToken()) {
  user.fetch()
}

const { locale } = useI18n()
const preferLang = window.navigator.language.replace('-', '_')
const documentLang = (languageAliasMap[locale.value] as string) || 'en_US'

if (preferLang in languageAliasMap) {
  locale.value = getOrSet('flat_language', preferLang)
}

document.documentElement.lang = documentLang

dayjs.locale(documentLang.toLocaleLowerCase())
dayjs.extend(utc)
dayjs.extend(timezone)
dayjs.extend(relativeTime)
dayjs.extend(LocalizedFormat)

watch(
  () => locale.value,
  (lang) => {
    set('flat_language', lang)
  },
)
</script>
