<template>
  <MainContent>
    <PageTitle title="首页" />
    <CommonList hoverable :items="topics" :is-end="isLastPage">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder :loading="loading" :error="error" @retry="send" />
    <template #panels>
      <RouterLink to="/publish">
        <NButton type="primary" round block>
          <template #icon>
            <NIcon :component="Pencil" />
          </template>
          发布话题
        </NButton>
      </RouterLink>
    </template>
  </MainContent>
</template>

<script setup lang="ts">
import TopicItem from '@/components/TopicItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { NButton, NIcon } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import CommonList from '@/components/CommonList.vue'
import { getAllTopics } from '@/services'
import { Pencil } from '@vicons/tabler'
import { usePagination } from '@alova/scene-vue'

let lastItemId = 0
const {
  loading,
  data: topics,
  isLastPage,
  error,
  onSuccess,
  send,
} = usePagination((page, limit) => getAllTopics(lastItemId, limit), {
  append: true,
  initialPageSize: 10,
})

onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})
</script>
