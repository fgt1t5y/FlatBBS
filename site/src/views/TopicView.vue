<template>
  <MainContent>
    <PageTitle title="话题" />
    <DiscussionList v-if="discussions.length" :discussions="discussions" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      @retry="retry"
    />
    <template #panels>
      <div>123</div>
    </template>
  </MainContent>
</template>

<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { getDiscussions } from '@/services/discussions'
import type { Discussion } from '@/types'
import { onMounted, ref } from 'vue'
import { useFetchData } from '@/utils'
import { useRoute } from 'vue-router'
import DiscussionList from '@/components/DiscussionList.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'

const route = useRoute()
const discussions = ref<Discussion[]>([])
const { isFailed, isLoading, fetch, retry } = useFetchData<Discussion[]>(
  getDiscussions,
  (data) => {
    discussions.value.push(...data)
  },
)

onMounted(() => {
  fetch(Number(route.params.topic_id))
})
</script>
