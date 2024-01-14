<template>
  <MainContent>
    <PageTitle title="版块" />
    <BoardDetail :slug="currentSlug" />
    <TopicList :topics="data" />
    <IntersectionObserver :disabled="noMore || isFailed" @reach="next" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      :no-more="noMore"
      @retry="fetch"
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
import { useFetchList } from '@/utils'
import { getTopicsByBoardSlug } from '@/services'
import type { Topic } from '@/types'
import BoardDetail from '@/components/BoardDetail.vue'
import { NButton } from 'naive-ui'
import { PenIcon } from 'tdesign-icons-vue-next'

const route = useRoute()

const currentSlug = computed(() => route.params.slug as string)
let lastSlug = currentSlug.value
const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<Topic>(
  getTopicsByBoardSlug,
  currentSlug,
)

watch(
  () => currentSlug.value,
  (to) => {
    if (!to || to === lastSlug) return
    lastSlug = to
    fetch(true)
  },
)
</script>
