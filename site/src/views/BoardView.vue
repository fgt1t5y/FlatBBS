<template>
  <MainContent
    :loading="boardInfoLoading"
    :error="boardInfoError"
    @retry="loadBoardInfo"
  >
    <PageTitle :title="boardInfo.data.name" />
    <CommonDetail
      :header-image-uri="boardInfo.data.header_img_uri"
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
    <RequestPlaceholder :loading="loading" :error="error" @retry="send" />
    <template #panels>
      <RouterLink :to="`/board/${currentSlug}/publish`">
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
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { getTopicsByBoardSlug, getBoardInfo } from '@/services'
import CommonDetail from '@/components/CommonDetail.vue'
import { NButton, NIcon } from 'naive-ui'
import { Pencil } from '@vicons/tabler'
import { usePagination } from '@alova/scene-vue'
import CommonList from '@/components/CommonList.vue'
import { useRequest } from 'alova'
import { useTitle } from '@/utils'

const route = useRoute()
const { setTitle } = useTitle('板块')

const currentSlug = computed(() => route.params.slug as string)
let lastSlug = currentSlug.value
let lastItemId = 0

const {
  loading: boardInfoLoading,
  data: boardInfo,
  error: boardInfoError,
  onSuccess: onBoardInfoSuccess,
  send: loadBoardInfo,
} = useRequest(() => getBoardInfo(currentSlug.value), {
  immediate: true,
  sendable: () => !!currentSlug.value,
})

const {
  loading,
  data: topics,
  isLastPage,
  error,
  onSuccess,
  send,
  reload,
} = usePagination(
  (page, limit) => getTopicsByBoardSlug(lastItemId, limit, currentSlug.value),
  {
    append: true,
    initialPageSize: 10,
  },
)

onBoardInfoSuccess(() => {
  setTitle(boardInfo.value.data.name)
})

onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})

watch(
  () => currentSlug.value,
  (to) => {
    if (!to || to === lastSlug) return
    lastSlug = to
    lastItemId = 0
    reload()
    loadBoardInfo()
  },
)
</script>
