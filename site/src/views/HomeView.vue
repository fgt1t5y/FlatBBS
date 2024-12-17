<template>
  <MainContent :title="$t('page.home')" reverse-panel>
    <PageTitle :title="$t('page.home')" />
    <CommonList :items="topics" :is-end="isLastPage">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder
      :loading="topicsLoading"
      :error="topicsError"
      @retry="send"
    />
    <template #panels>
      <div class="p-3 flex flex-col gap-2">
        <button class="btn btn-primary btn-md">
          {{ $t('action.publish') }}
        </button>
        <span class="text-base text-muted">{{ $t('board.hotspot') }}</span>
        <div v-for="board in boards">
          <RouterLink
            class="text-base flex gap-2 items-center hover:text-primary"
            :to="{ name: 'board_page', params: { slug: board.slug } }"
          >
            <Avatar class="size-6" :src="board.avatar_uri" rounded />
            <span>{{ board.name }}</span>
          </RouterLink>
        </div>
        <RequestPlaceholder
          :loading="boardsLoading"
          :error="boardsError"
          @retry="loadBoards"
        />
      </div>
    </template>
  </MainContent>
</template>

<script setup lang="ts">
import TopicItem from '@/components/TopicItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import CommonList from '@/components/CommonList.vue'
import Avatar from '@/components/Avatar.vue'
import { getAllTopics, getHotspotBoards } from '@/services'
import { usePagination, useRequest } from 'alova/client'

let lastItemId = 0

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  error: topicsError,
  send,
} = usePagination((page, limit) => getAllTopics(lastItemId, limit), {
  append: true,
  initialPageSize: 10,
}).onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})

const {
  loading: boardsLoading,
  data: boards,
  error: boardsError,
  send: loadBoards,
} = useRequest(() => getHotspotBoards())
</script>
