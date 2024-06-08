<template>
  <MainContent>
    <PageTitle title="话题" />
    <CommonList :items="discussions">
      <template #default="{ item, index }">
        <DiscussionItem :discussion="item" :index="index" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="send" />
    <RequestPlaceholder
      :loading="loading"
      :error="error"
      @retry="send"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import CommonList from '@/components/CommonList.vue'
import DiscussionItem from '@/components/DiscussionItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions } from '@/services/discussions'
import { useRoute } from 'vue-router'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed, watch } from 'vue'
import { usePagination } from '@alova/scene-vue'

const route = useRoute()

const currentTopicId = computed(() => Number(route.params.topic_id))
let lastTopicId = currentTopicId.value
let lastItemId = 0

const {
  loading,
  data: discussions,
  isLastPage,
  error,
  onSuccess,
  send,
  update,
} = usePagination(
  (page, limit) => getDiscussions(lastItemId, limit, currentTopicId.value),
  {
    append: true,
    initialPageSize: 10,
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
    update({ data: [] })
    send()
  },
)
</script>
