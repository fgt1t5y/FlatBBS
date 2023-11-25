<template>
  <MainContent>
    <PageTitle title="全部话题">
      <RouterLink to="/">
        <NText type="primary">FlatBBS</NText>
      </RouterLink>
      <template #extra>
        <NButton v-if="!isDesktop" circle quaternary>
          <SearchIcon size="18px" />
        </NButton>
      </template>
    </PageTitle>
    <TopicList :topics="data" />
    <IntersectionObserver :disabled="noMore || isFailed" @reach="fetch" />
    <RequestPlaceholder
      :is-loading="isLoading"
      :is-failed="isFailed"
      :no-more="noMore"
      @retry="fetch"
    />
  </MainContent>
  <div class="grid-panels-inner">
    <NPopover trigger="focus" :show-arrow="false">
      <template #trigger>
        <NInput
          ref="inputRef"
          :max-length="64"
          placeholder="搜索...（^K）"
          size="large"
          clearable
          round
        >
          <template #prefix>
            <SearchIcon size="18px" />
          </template>
        </NInput>
      </template>
      <span>搜索话题、版块和用户</span>
    </NPopover>
  </div>
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { NButton, NText, NInput, NPopover } from 'naive-ui'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import { isDesktop, useFetchList } from '@/utils'
import { getTopicList } from '@/services'
import type { Topic } from '@/types'
import { SearchIcon } from 'tdesign-icons-vue-next'

const { isLoading, isFailed, data, noMore, fetch } = useFetchList<Topic[]>(
  getTopicList,
  0,
)
</script>
