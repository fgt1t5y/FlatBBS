<template>
  <div class="tabs" role="tablist">
    <div v-for="tab in tabs" :key="tab.label" class="tab-item" role="tab">
      <RouterLink :to="{ name: tab.routeName, params: tab.params }">
        {{ tab.label }}
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { RouteTab } from '@/types'

defineOptions({
  name: 'CommonRouteTabs',
})

interface CommonRouteTabsProps {
  tabs: RouteTab[]
}

const props = defineProps<CommonRouteTabsProps>()
</script>
