<template>
  <MainContent>
    <PageTitle title="首页" />
    <CommonList>
      <TopicItem v-for="item in topics" :key="item.id" :topic="item" />
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder
      :is-loading="loading"
      :is-failed="!!error"
      :no-more="isLastPage"
      @retry="send"
    />
    <template #panels>
      <RouterLink to="/publish">
        <NButton type="primary" round block>
          <template #icon>
            <PenIcon size="20px" />
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
import { NButton } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import CommonList from '@/components/CommonList.vue'
import { getAllTopics } from '@/services'
import { PenIcon } from 'tdesign-icons-vue-next'
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
