<template>
  <MainContent>
    <PageTitle title="全部话题">
      <RouterLink to="/">
        <NText type="primary">FlatBBS</NText>
      </RouterLink>
      <template #extra>
        <NButton
          v-if="!isDesktop"
          circle
          quaternary
          @click="router.push({ path: '/search' })"
        >
          <SearchIcon size="18px" />
        </NButton>
      </template>
    </PageTitle>
    <TopicList :topics="data" />
    <IntersectionObserver :disabled="noMore || isFailed" @reach="next" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      :no-more="noMore"
      @retry="fetch"
    />
  </MainContent>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { NButton, NText } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { isDesktop, useFetchList } from '@/utils'
import { getAllTopics } from '@/services'
import type { Topic } from '@/types'
import { SearchIcon } from 'tdesign-icons-vue-next'
import router from '@/router'

const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<Topic>(
  getAllTopics,
  0,
)
</script>
