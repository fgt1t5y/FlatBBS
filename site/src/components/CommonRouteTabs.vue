<template>
  <div class="tabs">
    <div v-for="tab in tabs" :key="tab.label" class="tab-item">
      <RouterLink :to="{ name: tab.routeName, params: tab.params }">
        {{ tab.label }}
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { IRouteTab } from '@/types'

defineOptions({
  name: 'CommonRouteTabs',
})

interface CommonRouteTabsProps {
  tabs: IRouteTab[]
}

const props = defineProps<CommonRouteTabsProps>()
</script>
