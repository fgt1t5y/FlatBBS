<template>
  <Navbar v-if="isDesktop" :is-loggined="user.isLogin" />
  <div id="flatbbs">
    <CommonGrid>
      <RouterView v-slot="{ Component }">
        <KeepAlive :max="10">
          <component :is="Component" />
        </KeepAlive>
      </RouterView>
    </CommonGrid>
    <NBackTop />
  </div>
  <NavbarMobile v-if="!isDesktop && $route.meta.showBottomNav" />
</template>

<script setup lang="ts">
import CommonGrid from '@/components/CommonGrid.vue'
import { isDesktop } from '@/utils'
import Navbar from '@/components/Navbar.vue'
import NavbarMobile from '@/components/NavbarMobile.vue'
import { useMessage, NBackTop } from 'naive-ui'
import { useUserStore } from '@/stores'

window.$message = useMessage()

const user = useUserStore()
</script>
