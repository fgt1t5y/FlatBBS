<template>
  <nav class="navbar h-navbar">
    <div class="nav-inner">
      <RouterLink title="FlatBBS" to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <CommonPopover
          trigger="click"
          placement="bottom-end"
          :duration="0"
          focus-trap
        >
          <button :title="$t('user_menu')">
            <Avatar
              ref="avatarRef"
              role="button"
              class="size-10 cursor-pointer"
              :src="user.info.avatar_uri"
              rounded
            />
          </button>
          <template #body>
            <div class="nav-user-panel">
              <div class="p-3 text-base flex gap-2 border-bt">
                <Avatar class="size-14" :src="user.info.avatar_uri" rounded />
                <div>
                  <div class="text-base font-bold">
                    {{ user.info.display_name }}
                  </div>
                  <div class="text-muted">@{{ user.info.username }}</div>
                </div>
              </div>
              <CommonRouteMenu class="border-bt" :items="userPanelMenuItems" />
              <button class="route-menu-item text-danger" @click="user.quit">
                {{ $t('action.logout') }}
              </button>
            </div>
          </template>
        </CommonPopover>
      </div>
      <div v-else>
        <RouterLink
          class="btn btn-primary btn-md"
          :to="{ name: 'auth', query: { next: $route.fullPath } }"
        >
          {{ $t('page.register_or_login') }}
        </RouterLink>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores'
import { useI18n } from 'vue-i18n'
import Avatar from './Avatar.vue'
import CommonPopover from './CommonPopover.vue'
import CommonRouteMenu from './CommonRouteMenu.vue'

import { computed } from 'vue'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
const { t } = useI18n()

const userPanelMenuItems = computed(() => {
  return [
    {
      routeName: 'user',
      label: t('page.my_page'),
      params: { username: user.info?.username },
    },
    {
      routeName: 'settings',
      label: t('page.settings'),
      params: null,
    },
  ]
})
</script>
