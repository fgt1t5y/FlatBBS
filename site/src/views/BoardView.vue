<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="boardInfo?.data?.name" />
    <CommonDetail
      :avatar-uri="boardInfo.data.avatar_uri"
      :name="boardInfo.data.name"
      :introduction="boardInfo.data.description"
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
import { usePagination } from '@alova/scene-vue'
import CommonList from '@/components/CommonList.vue'
import { useRequest } from 'alova'
import { useTitle } from '@/utils'

const route = useRoute()
const { setTitle } = useTitle('板块')

const currentSlug = route.params.slug as string

let lastItemId = 0

const {
  loading: boardInfoLoading,
  data: boardInfo,
  error: boardInfoError,
  onSuccess: onBoardInfoSuccess,
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(currentSlug), {
  immediate: true,
  sendable: () => !!currentSlug,
})

const {
  loading,
  data: topics,
  isLastPage,
  error: topicsError,
  onSuccess: onTopicsSuccess,
  send,
} = usePagination(
  (page, limit) => getTopicsByBoardSlug(lastItemId, limit, currentSlug),
  {
    append: true,
    initialPageSize: 10,
    immediate: false,
    sendable: () => !!boardInfo.value,
  },
)

onBoardInfoSuccess(() => {
  setTitle(boardInfo.value.data.name)
  send()
})

onTopicsSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})
</script>
