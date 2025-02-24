<template>
  <MainContent :title="$t('page.visit_logs')" disable-panels>
    <PageTitle :title="$t('page.visit_logs')" />
    <CommonList :items="visitLogs" :is-end="isLastPage">
      <template #default="{ item }">
        <component
          :is="visitLogComponentMap[item.visitable_type]"
          :item="item"
        />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder :loading="loading" :error="error" @retry="send" />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonList from '@/components/CommonList.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import { getVisitLogs } from '@/services'
import { usePagination } from 'alova/client'
import { visitLogComponentMap } from '@/components/log'

const {
  loading,
  data: visitLogs,
  isLastPage,
  error,
  send,
} = usePagination(() => getVisitLogs(0, 10, undefined))
</script>
