<template>
  <nav
    class="z-10 flex items-center sticky top-0 shadow-md px-3 bg-white dark:bg-navdark justify-center"
    style="height: 52px"
  >
    <div class="w-full-page flex justify-between items-center grow">
      <RouterLink to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <Avatar
          ref="avatarRef"
          tabindex="0"
          role="button"
          class="size-10 cursor-pointer"
          :src="user.info.avatar_uri"
          rounded
          @click="openMenu"
        />
        <div
          ref="menuRef"
          role="tooltip"
          class="user-panel bg-white shadow-md p-3 dark:bg-navdark"
          :style="{
            display: isPositioned ? 'block' : 'none',
            ...floatingStyles,
          }"
        >
          <div class="text-base">
            <b>{{ user.info.display_name }}</b>
            <span class="text-muted">@{{ user.info.username }}</span>
          </div>
          <div class="flex flex-col gap-2">
            <RouterLink to="/settings">
              <button class="btn btn-primary btn-md w-full">设置</button>
            </RouterLink>
            <button class="btn btn-air btn-md">退出登录</button>
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
const showMenu = ref(false)

const { floatingStyles, update, isPositioned } = useFloating(
  avatarRef,
  menuRef,
  {
    placement: 'bottom-end',
    open: showMenu,
    whileElementsMounted: autoUpdate,
  },
)

const openMenu = () => {
  showMenu.value = true
}

onClickOutside(menuRef, () => {
  if (showMenu.value) {
    showMenu.value = false
  }
})

window.addEventListener('resize', update)
</script>
