<template>
  <MainContent>
    <PageTitle title="话题" />
    <DiscussionList :discussions="discussions" />
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder
      :is-loading="loading"
      :is-failed="!!error"
      @retry="send"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions } from '@/services/discussions'
import { useRoute } from 'vue-router'
import DiscussionList from '@/components/DiscussionList.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { usePagination } from '@alova/scene-vue'

const route = useRoute()

const currentTopicId = computed(() => Number(route.params.topic_id ?? '0'))
let lastTopicId = currentTopicId.value
let lastItemId = 0

const {
  loading,
  data: discussions,
  isLastPage,
  error,
  onSuccess,
  send,
} = usePagination(
  (page, limit) => getDiscussions(lastItemId, limit, currentTopicId.value),
  {
    append: true,
    initialPageSize: 10,
    watchingStates: [currentTopicId],
  },
)

onSuccess(() => {
  const items = discussions.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})

watch(
  () => currentTopicId.value,
  (to) => {
    if (!to || to === lastTopicId) return
    lastTopicId = to
    lastItemId = 0
  },
)
</script>
