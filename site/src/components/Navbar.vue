<template>
  <nav class="navbar h-navbar">
    <div class="w-full-page flex justify-between items-center grow px-3">
      <RouterLink title="FlatBBS" to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <button :title="$t('user_menu')" @click="openMenu">
          <Avatar
            ref="avatarRef"
            role="button"
            class="size-10 cursor-pointer"
            :src="user.info.avatar_uri"
            rounded
          />
        </button>
        <div
          v-show="isPositioned"
          ref="menuRef"
          role="tooltip"
          class="user-panel shadow-lg rounded p-3 bg-content border border-content"
          :style="floatingStyles"
          @keydown="handleMenuKeydown"
        >
          <div
            ref="focusTargetRef"
            aria-label="用户菜单"
            class="absolute h-0 w-0"
            tabindex="0"
          ></div>
          <div class="text-base flex gap-2 mb-2">
            <div class="shrink-0">
              <Avatar class="size-14" :src="user.info.avatar_uri" rounded />
            </div>
            <div>
              <b>{{ user.info.display_name }}</b>
              <span class="text-muted">@{{ user.info.username }}</span>
            </div>
          </div>
          <div class="flex gap-1">
            <button
              class="btn-md btn-air grow"
              @click="$router.push({ name: 'settings' })"
            >
              {{ $t('page.settings') }}
            </button>
            <button class="btn-md btn-air danger" @click="user.quit">
              {{ $t('action.logout') }}
            </button>
          </div>
        </div>
      </div>
      <div v-else>
        <RouterLink class="btn btn-primary btn-md" to="/auth">
          {{ $t('page.register_or_login') }}
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
