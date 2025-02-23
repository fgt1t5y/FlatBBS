<template>
  <nav class="navbar h-navbar">
    <div class="nav-inner">
      <RouterLink title="FlatBBS" to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <Popover
          v-model:open="openUserPanel"
          trigger="manual"
          placement="bottom-end"
          focus-trap
          :duration="0"
          @click-outside="closeUserPanel"
        >
          <button :title="$t('user_menu')" @click="openUserPanel = true">
            <Avatar class="size-10" :src="user.info.avatar_uri" rounded />
          </button>
          <template #body>
            <div class="nav-user-panel">
              <SimpleUserInfo class="p-3 border-bt" :user="user.info" />
              <CommonRouteMenu class="border-bt" :items="userPanelMenuItems" />
              <button class="route-menu-item text-danger" @click="user.quit">
                {{ $t('action.logout') }}
              </button>
            </div>
          </template>
        </Popover>
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
import Popover from './Popover.vue'
import CommonRouteMenu from './CommonRouteMenu.vue'
import SimpleUserInfo from './SimpleUserInfo.vue'

import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
const route = useRoute()
const { t } = useI18n()

const openUserPanel = ref<boolean>(false)

const closeUserPanel = () => {
  openUserPanel.value = false
}

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

watch(() => route.fullPath, closeUserPanel)
</script>
