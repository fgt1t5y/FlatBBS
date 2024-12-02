<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="boardInfo?.name" />
    <CommonDetail
      :avatar-uri="boardInfo.avatar_uri"
      :name="boardInfo.name"
      :introduction="boardInfo.description"
    />
    <CommonList hoverable :items="topics" :is-end="isLastPage">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder :loading="loading" :error="topicsError" @retry="send" />
    <template #panels>
      <RouterLink :to="`/board/${currentSlug}/publish`">
        <button class="btn btn-primary btn-md w-full">发布话题</button>
      </RouterLink>
    </template>
  </MainContent>
</template>

<script setup lang="ts">
import TopicItem from '@/components/TopicItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { useRoute } from 'vue-router'
import { getTopicsByBoardSlug, getBoardInfo } from '@/services'
import CommonDetail from '@/components/CommonDetail.vue'
import CommonList from '@/components/CommonList.vue'
import { useRequest, usePagination } from 'alova/client'
import { useTitle } from '@/utils'

const route = useRoute()
const { setTitle } = useTitle('板块')

const currentSlug = route.params.slug as string

let lastItemId = 0

const {
  loading: boardInfoLoading,
  data: boardInfo,
  error: boardInfoError,
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(currentSlug), {
  immediate: true,
  middleware(_, next) {
    if (currentSlug) {
      next()
    }
  },
}).onSuccess(() => {
  setTitle(boardInfo.value.name)
  send()
})

const {
  loading,
  data: topics,
  isLastPage,
  error: topicsError,
  send,
} = usePagination(
  (page, limit) => getTopicsByBoardSlug(lastItemId, limit, currentSlug),
  {
    append: true,
    initialPageSize: 10,
    immediate: false,
    middleware(_, next) {
      if (boardInfo.value) {
        next()
      }
    },
  },
).onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})
</script>
