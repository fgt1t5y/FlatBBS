<template>
  <div class="tabs">
    <RouterLink
      v-for="tab in tabs"
      :key="tab.label"
      class="tab-item"
      :to="{ name: tab.routeName, params: tab.params }"
    >
      {{ tab.label }}
    </RouterLink>
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
