<template>
  <MainContent>
    <PageTitle title="版块" />
    <BoardDetail :slug="currentSlug" />
    <TopicList :topics="topics" />
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
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { getTopicsByBoardSlug } from '@/services'
import BoardDetail from '@/components/BoardDetail.vue'
import { NButton } from 'naive-ui'
import { PenIcon } from 'tdesign-icons-vue-next'
import { usePagination } from '@alova/scene-vue'

const route = useRoute()

const currentSlug = computed(() => route.params.slug as string)
let lastSlug = currentSlug.value
let lastItemId = 0

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
  },
)
</script>
