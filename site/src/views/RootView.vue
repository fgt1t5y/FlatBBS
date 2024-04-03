<template>
  <CommonGrid>
    <RouterView v-slot="{ Component }">
      <KeepAlive :max="10">
        <component :is="Component" />
      </KeepAlive>
    </RouterView>
  </CommonGrid>
  <NBackTop />
  <NavbarMobile v-if="!isDesktop && route.meta.showBottomNav" />
</template>

<script setup lang="ts">
import CommonGrid from '@/components/CommonGrid.vue'
import { isDesktop } from '@/utils'
import NavbarMobile from '@/components/NavbarMobile.vue'
import { useMessage, NBackTop } from 'naive-ui'

import { useRoute } from 'vue-router'

const route = useRoute()
window.$message = useMessage()
</script>
