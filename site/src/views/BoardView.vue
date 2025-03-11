<template>
  <MainContent
    :loading="boardLoading"
    :error="boardError"
    :title="$t('board.board')"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="board.name" />
    <CommonDetail
      :avatar-uri="board.avatar_uri"
      :name="board.name"
      :introduction="board.description"
    >
      <div class="flex gap-2 text-base">
        <span class="font-bold">{{ board.topic_count }}</span>
        <span class="text-muted">{{ $t('board.topic_count') }}</span>
      </div>
    </CommonDetail>
    <CommonList
      :items="topics"
      :is-end="isLastPage"
      :loading="topicsLoading"
      :error="topicsError"
      @retry="loadTopics"
    >
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="nextPage" />
    <template #aside>
      <RouterLink
        class="btn btn-primary btn-md w-full"
        :to="{ name: 'board_publish', params: { slug: slug } }"
      >
        {{ $t('action.publish_topic') }}
      </RouterLink>
    </template>
  </MainContent>
</template>

<script setup lang="ts">
import TopicItem from '@/components/TopicItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
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

const {
  loading: boardLoading,
  data: board,
  error: boardError,
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(slug)).onSuccess(() => {
  setTitle(board.value?.name)
  loadTopics()
})

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  page: topicPage,
  error: topicsError,
  send: loadTopics,
} = usePagination((page, limit) => getTopicsByBoardSlug(page, limit, slug), {
  append: true,
  initialPageSize: 10,
  immediate: false,
  total: () => board.value.topic_count,
})

const nextPage = () => {
  topicPage.value++
}

onActivated(() => {
  if (board.value?.name) {
    setTitle(board.value.name)
  }
})
</script>
