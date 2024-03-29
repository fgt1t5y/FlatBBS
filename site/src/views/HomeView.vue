<template>
  <MainContent>
    <PageTitle title="首页">
      <RouterLink to="/">
        <NText type="primary" class="page-title-title">FlatBBS</NText>
      </RouterLink>
      <template #extra>
        <NButton
          circle
          quaternary
          title="搜索(Ctrl + K)"
          @click="router.push({ path: '/search' })"
        >
          <SearchIcon size="18px" />
        </NButton>
      </template>
    </PageTitle>
    <TopicList :topics="topics" />
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
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { NButton, NText } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { getAllTopics } from '@/services'
import { SearchIcon, PenIcon } from 'tdesign-icons-vue-next'
import router from '@/router'
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
