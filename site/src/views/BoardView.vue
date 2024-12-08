<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    :title="$t('board')"
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
    <IntersectionObserver :disabled="isLastPage" @reach="loadTopics" />
    <RequestPlaceholder
      :loading="loading"
      :error="topicsError"
      @retry="loadTopics"
    />
    <template #panels>
      <RouterLink :to="`/board/${currentSlug}/publish`">
        <button class="btn btn-primary btn-md w-full">
          {{ $t('action.publish_topic') }}
        </button>
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
import { useI18n } from 'vue-i18n'
import { onActivated } from 'vue'

const route = useRoute()
const { t } = useI18n()
const { setTitle } = useTitle(t('board'))

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
  loadTopics()
})

const {
  loading,
  data: topics,
  isLastPage,
  error: topicsError,
  send: loadTopics,
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

onActivated(() => {
  if (boardInfo?.value?.name) {
    setTitle(boardInfo.value.name)
  }
})
</script>
