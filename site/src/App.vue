<template>
  <Navbar v-if="isDesktop" />
  <RouterView />
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
  <Message />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useTheme } from './stores'
import { getOrSet, set } from './utils'
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

const theme = useTheme()
theme.init()

const { locale } = useI18n()
const preferLang = window.navigator.language.replace('-', '_')

if (preferLang in languageAliasMap) {
  locale.value = getOrSet('flat_language', preferLang)
}

const documentLang = (languageAliasMap[locale.value] as string) || 'en'

document.documentElement.lang = locale.value

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
