<template>
  <MainContent :title="$t('page.visit_logs')">
    <PageTitle :title="$t('page.visit_logs')" />
    <div v-for="(items, date) in groupedItems" :key="date">
      <div class="p-3 text-base">{{ date }}</div>
      <component
        :is="visitLogComponentMap[item.visitable_type]"
        v-for="item in items"
        :key="item.id"
        :item="item"
      />
    </div>
    <IntersectionObserver :disabled="isLastPage" @reach="nextPage" />
    <RequestPlaceholder :loading="loading" :error="error" @retry="send" />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import { getVisitLogs } from '@/services'
import { usePagination } from 'alova/client'
import { visitLogComponentMap } from '@/components/log'
import { computed, onActivated } from 'vue'

import type { UserVisitLog } from '@/types'

const {
  loading,
  data: visitLogs,
  isLastPage,
  page,
  error,
  send,
  reload,
} = usePagination((page, limit) => getVisitLogs(page, limit), {
  append: true,
  preloadNextPage: false,
})

const nextPage = () => {
  page.value++
}

const groupedItems = computed(() => {
  return visitLogs.value.reduce(
    (acc, item) => {
      const date = item.updated_at.split('T')[0] // Assuming date is in ISO format
      if (!acc[date]) {
        acc[date] = []
      }
      acc[date].push(item)
      return acc
    },
    {} as Record<string, UserVisitLog[]>,
  )
})

onActivated(reload)
</script>
