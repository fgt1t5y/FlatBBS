<template>
  <MainContent>
    <PageTitle title="首页">
      <RouterLink to="/">
        <NText type="primary">FlatBBS</NText>
      </RouterLink>
      <template #extra>
        <NButton
          circle
          quaternary
          title="搜索(Ctrl + K)"
          @click="onSearchButtonClick"
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
import { useStateStore } from '@/stores'

const { isLoading, isFailed, data, noMore, fetch, next } = useFetchList<Topic>(
  getAllTopics,
  0,
)
const s = useStateStore()
const onSearchButtonClick = () => {
  if (isDesktop.value) {
    s.showSearchPanel = true
    return
  }

  router.push({ path: '/search' })
}
</script>
