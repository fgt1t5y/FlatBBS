<template>
  <nav
    class="z-10 flex items-center sticky top-0 shadow-md px-3 bg-white dark:bg-navdark"
    style="height: 52px"
  >
    <div class="flex justify-between items-center grow">
      <RouterLink to="/">
        <span class="text-2xl font-bold">FlatBBS</span>
      </RouterLink>
      <div v-if="user.isLogin && user.info">
        <Avatar
          class="size-10 cursor-pointer"
          :src="user.info.avatar_uri"
          rounded
        />
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

defineOptions({
  name: 'Navbar',
})

const user = useUserStore()
</script>
