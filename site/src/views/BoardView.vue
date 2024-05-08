<template>
  <MainContent>
    <PageTitle title="版块" />
    <CommonDetail
      v-if="!boardInfoLoading"
      :header-image-uri="boardInfo.header_img_uri"
      :avatar-uri="boardInfo.avatar_uri"
      :name="boardInfo.name"
      :introduction="boardInfo.description"
    />
    <CommonList hoverable :items="topics">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder
      :is-loading="loading"
      :is-failed="!!error"
      :no-more="isLastPage"
      @retry="send"
    />
    <template #panels>
      <RouterLink :to="`/board/${currentSlug}/publish`">
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
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { getTopicsByBoardSlug, getBoardInfo } from '@/services'
import CommonDetail from '@/components/CommonDetail.vue'
import { NButton } from 'naive-ui'
import { PenIcon } from 'tdesign-icons-vue-next'
import { usePagination } from '@alova/scene-vue'
import CommonList from '@/components/CommonList.vue'
import { useRequest } from 'alova'

const route = useRoute()

const currentSlug = computed(() => route.params.slug as string)
let lastSlug = currentSlug.value
let lastItemId = 0

const {
  loading: boardInfoLoading,
  data: boardInfo,
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
