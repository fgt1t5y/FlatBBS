<template>
  <nav
    class="z-10 flex items-center sticky top-0 shadow-md bg-white dark:bg-navdark justify-center"
    style="height: 52px"
  >
    <div class="w-full-page flex justify-between items-center grow px-3">
      <RouterLink title="FlatBBS" to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <button title="你的头像，点击打开用户菜单" @click="openMenu">
          <Avatar
            ref="avatarRef"
            role="button"
            class="size-10 cursor-pointer"
            :src="user.info.avatar_uri"
            rounded
          />
        </button>
        <div
          ref="menuRef"
          role="tooltip"
          class="user-panel bg-white shadow-md p-3 dark:bg-navdark focus:outline-1 focus:outline-indigo-600"
          :style="{
            display: isPositioned ? 'block' : 'none',
            ...floatingStyles,
          }"
          @keydown="handleMenuKeydown"
        >
          <div
            ref="focusTargetRef"
            aria-label="用户菜单"
            class="absolute h-0 w-0"
            tabindex="0"
          ></div>
          <div class="text-base">
            <b>{{ user.info.display_name }}</b>
            <span class="text-muted">@{{ user.info.username }}</span>
          </div>
          <div class="flex flex-col gap-2">
            <RouterLink to="/settings">
              <button class="btn btn-primary btn-md w-full">设置</button>
            </RouterLink>
            <button class="btn btn-air btn-md" @click="user.quit">
              退出登录
            </button>
          </div>
        </div>
      </div>
      <div v-else>
        <RouterLink to="/auth">
          <button class="btn btn-primary btn-md">注册 / 登录</button>
        </RouterLink>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores'
import Avatar from './Avatar.vue'
import { ref } from 'vue'
import { useFloating, autoUpdate } from '@floating-ui/vue'
import { onClickOutside } from '@vueuse/core'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
const avatarRef = ref<HTMLElement>()
const menuRef = ref<HTMLElement>()
const focusTargetRef = ref<HTMLElement>()
const showMenu = ref(false)

const { floatingStyles, isPositioned } = useFloating(avatarRef, menuRef, {
  placement: 'bottom-end',
  open: showMenu,
  whileElementsMounted: autoUpdate,
})

const openMenu = () => {
  showMenu.value = true

  let t = window.setTimeout(() => {
    focusTargetRef.value?.focus()
    clearTimeout(t)
  }, 10)
}

const handleMenuKeydown = (ev: KeyboardEvent) => {
  if (ev.key === 'Escape') {
    showMenu.value = false

    let t = window.setTimeout(() => {
      const el = document.getElementById('main-content')
      if (!el) {
        return
      }

      el.focus()
      clearTimeout(t)
    }, 10)
  }
}

onClickOutside(menuRef, () => {
  if (showMenu.value) {
    showMenu.value = false
  }
})
</script>
