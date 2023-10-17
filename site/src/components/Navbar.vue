<template>
  <header class="nav-container">
    <nav class="nav">
      <RouterLink to="/" class="nav-brand">
        <TypographyTitle :heading="5">Flat BBS</TypographyTitle>
      </RouterLink>
      <div class="nav-opt" size="medium">
        <RouterLink to="/" class="mob-show icon-link hover-card">
          <IconSearch :size="20" />
        </RouterLink>
        <Input
          ref="inputRef"
          class="mob-hidden"
          :max-length="64"
          placeholder="搜索..."
        >
          <template #prefix>
            <IconSearch />
          </template>
          <template #suffix>
            <kbd>^K</kbd>
          </template>
        </Input>
        <button
          class="icon-link hover-card"
          title="主题模式：跟随系统/浅色/暗色"
          @click="toggleTheme"
        >
          <IconComputer v-if="theme === 'auto'" :size="20" />
          <IconSun v-else-if="theme === 'light'" :size="20" />
          <IconMoon v-else :size="20" />
        </button>
        <Dropdown
          position="br"
          trigger="click"
          class="user-menu"
          content-class="user-menu"
        >
          <Avatar
            v-if="isLogin"
            :size="32"
            :image-url="info.avatar_uri"
            title="用户菜单"
          />
          <Avatar v-else :size="32">登录</Avatar>
          <template #content>
            <header>
              <Avatar :size="56" :image-url="info.avatar_uri" />
              <div class="user-menu-info">
                <TypographyTitle :heading="5">
                  {{ info.username ?? '未登录' }}
                </TypographyTitle>
                <TypographyText type="secondary">
                  {{ info.email }}
                </TypographyText>
              </div>
            </header>
            <main>
              <div v-if="isLogin">
                <Doption
                  v-for="options in userMenuOptions"
                  :key="options.i"
                  class="menu-link"
                >
                  <RouterLink :to="options.to">{{ options.text }}</RouterLink>
                </Doption>
              </div>
              <div v-else>
                <Doption
                  v-for="options in guestMenuOptions"
                  :key="options.i"
                  class="menu-link"
                >
                  <RouterLink :to="options.to">{{ options.text }}</RouterLink>
                </Doption>
              </div>
            </main>
          </template>
        </Dropdown>
      </div>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { useTheme, useUserStore } from '@/stores'
import {
  TypographyTitle,
  TypographyText,
  Input,
  Avatar,
  Dropdown,
  Doption,
} from '@arco-design/web-vue'
import {
  IconSearch,
  IconSun,
  IconComputer,
  IconMoon,
} from '@arco-design/web-vue/es/icon'
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'
import '@/style/Navbar.css'

defineOptions({
  name: 'Navbar',
})

interface NavbarProps {
  isLogin: boolean
}
interface UserMenuOptionsProps {
  i: number
  text: string
  to: string
}

const { theme, toggleTheme } = useTheme()
const inputRef = ref<InstanceType<typeof Input>>()
const props = withDefaults(defineProps<NavbarProps>(), {
  isLogin: false,
})
const { info } = useUserStore()
const userMenuOptions = [
  {
    i: 0,
    text: '设置',
    to: '/settings',
  },
  {
    i: 1,
    text: '退出登录',
    to: '/',
  },
] as UserMenuOptionsProps[]
const guestMenuOptions = [
  {
    text: '登录 / 注册',
    to: '/auth',
  },
] as UserMenuOptionsProps[]

const focusInput = (ev: KeyboardEvent) => {
  if (ev.key === 'k' && ev.ctrlKey) {
    ev.preventDefault()
    inputRef.value?.focus()
  }
}

onMounted(() => {
  document.addEventListener('keydown', focusInput)
})
</script>
