<template>
  <MainContent
    :loading="boardLoading"
    :error="boardError"
    :title="$t('board.board')"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="board.name" />
    <div class="p-3 flex flex-col gap-2 border-bt">
      <div class="flex justify-between items-end">
        <Avatar class="size-16 md:size-24" :src="board.avatar_uri" />
      </div>
      <div>
        <div class="text-lg font-bold">
          {{ board.name }}
        </div>
        <div class="text-base text-muted">{{ board.description }}</div>
      </div>
      <div class="flex gap-2 text-base">
        <span class="font-bold">{{ board.topic_count }}</span>
        <span class="text-muted">{{ $t('board.topic_count') }}</span>
      </div>
    </div>
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
        :to="{ name: 'board_publish', params: { boardSlug } }"
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
import Avatar from '@/components/Avatar.vue'
import { useRoute } from 'vue-router'
import { getTopics, getBoard } from '@/services'
import CommonList from '@/components/CommonList.vue'
import { useRequest, usePagination } from 'alova/client'
import { useTitle } from '@/utils'
import { useI18n } from 'vue-i18n'
import { onActivated } from 'vue'

const route = useRoute()
const { t } = useI18n()
const { setTitle } = useTitle(t('board.board'))

const boardSlug = route.params.boardSlug as string

const {
  loading: boardLoading,
  data: board,
  error: boardError,
  send: loadBoardInfo,
} = useRequest(() => getBoard(boardSlug)).onSuccess(() => {
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
} = usePagination((page, limit) => getTopics(page, limit, boardSlug), {
  append: true,
  preloadNextPage: false,
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
