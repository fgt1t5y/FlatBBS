<template>
  <nav class="navbar h-navbar">
    <div class="w-full-page flex justify-between items-center grow px-3">
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
            <div class="p-3">
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
import Avatar from './Avatar.vue'
import CommonPopover from './CommonPopover.vue'

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
</script>
