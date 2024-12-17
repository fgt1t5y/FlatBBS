<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    :title="$t('board.board')"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="boardInfo.name" />
    <CommonDetail
      :avatar-uri="boardInfo.avatar_uri"
      :name="boardInfo.name"
      :introduction="boardInfo.description"
    >
      <div class="flex gap-2 text-base">
        <span class="font-bold">{{ boardInfo.topic_count }}</span>
        <span class="text-muted">{{ $t('board.topic_count') }}</span>
      </div>
    </CommonDetail>
    <CommonList hoverable :items="topics" :is-end="isLastPage">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="loadTopics" />
    <RequestPlaceholder
      :loading="topicsLoading"
      :error="topicsError"
      @retry="loadTopics"
    />
    <template #panels>
      <RouterLink :to="`/board/${slug}/publish`">
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
const { setTitle } = useTitle(t('board.board'))

const slug = route.params.slug as string

let lastItemId = 0

const {
  loading: boardInfoLoading,
  data: boardInfo,
  error: boardInfoError,
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(slug)).onSuccess(() => {
  setTitle(boardInfo.value?.name)
  loadTopics()
})

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  error: topicsError,
  send: loadTopics,
} = usePagination(
  (page, limit) => getTopicsByBoardSlug(lastItemId, limit, slug),
  {
    append: true,
    initialPageSize: 10,
    immediate: false,
  },
).onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})

onActivated(() => {
  if (boardInfo.value?.name) {
    setTitle(boardInfo.value.name)
  }
})
</script>
