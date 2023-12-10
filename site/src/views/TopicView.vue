<template>
  <MainContent>
    <PageTitle title="话题" />
    <DiscussionList :discussions="data" />
    <IntersectionObserver :disabled="noMore || isFailed" @reach="next" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      @retry="fetch"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions } from '@/services/discussions'
import type { Discussion } from '@/types'
import { useFetchList } from '@/utils'
import { useRoute } from 'vue-router'
import DiscussionList from '@/components/DiscussionList.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { computed } from 'vue'

const route = useRoute()
const currentTopicId = computed(() => Number(route.params.topic_id ?? '0'))
const { isLoading, isFailed, data, noMore, fetch, next } =
  useFetchList<Discussion>(getDiscussions, currentTopicId.value)
</script>
