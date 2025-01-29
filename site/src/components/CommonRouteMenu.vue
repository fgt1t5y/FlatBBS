<template>
  <div class="route-menu">
    <RouterLink
      v-for="item in items"
      :key="item.label"
      :to="{ name: item.routeName, params: item.params }"
      class="route-menu-item"
    >
      {{ item.label }}
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import type { IRouteMenuItem } from '@/types'

defineOptions({
  name: 'CommonRouteTabs',
})

interface CommonRouteTabsProps {
  items: IRouteMenuItem[]
}

const props = defineProps<CommonRouteTabsProps>()
</script>
