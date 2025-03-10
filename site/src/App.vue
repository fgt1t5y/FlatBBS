<template>
  <Navbar v-if="isDesktop" />
  <RouterView />
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
  <MessageContainer />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useTheme, useLocalSettings } from './stores'
import { isDesktop } from '@/utils'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import MessageContainer from '@/components/MessageContainer.vue'
import { useI18n } from 'vue-i18n'
import { watch } from 'vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import LocalizedFormat from 'dayjs/plugin/localizedFormat'

const theme = useTheme()
const settings = useLocalSettings()
const { locale } = useI18n()

theme.init()
settings.init()
settings.$subscribe(settings.save)

locale.value = settings.language
document.documentElement.lang = settings.timezone

dayjs.locale(settings.language.toLocaleLowerCase())
dayjs.extend(utc)
dayjs.extend(timezone)
dayjs.extend(relativeTime)
dayjs.extend(LocalizedFormat)
dayjs.tz.setDefault(settings.timezone)

watch(
  () => locale.value,
  (lang) => {
    settings.language = lang
  },
)
</script>
