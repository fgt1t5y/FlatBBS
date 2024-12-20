<template>
  <MainContent :loading="userLoading" :error="userError" @retry="loadUser">
    <PageTitle :title="user.display_name" />
    <CommonDetail
      :avatar-uri="user.avatar_uri"
      :name="user.display_name"
      :introduction="user.introduction"
      avatar-rounded
    />
    <CommonList :items="topics" :is-end="isLastPage">
      <template #default="{ item }">
        <TopicItem :topic="item" />
      </template>
    </CommonList>
    <IntersectionObserver :disabled="isLastPage" @reach="loadTopics" />
    <RequestPlaceholder
      :loading="topicsLoading"
      :error="topicsError"
      @retry="loadTopics"
    />
  </MainContent>
</template>

<script setup lang="ts">
import CommonDetail from '@/components/CommonDetail.vue'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonList from '@/components/CommonList.vue'
import TopicItem from '@/components/TopicItem.vue'
import IntersectionObserver from '@/components/IntersectionObserver.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import { getUserDetailByUsername, getTopicsByUsername } from '@/services'
import { useTitle } from '@/utils'
import { useRequest, usePagination } from 'alova/client'
import { onActivated } from 'vue'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'

const route = useRoute()
const { t } = useI18n()
const { setTitle } = useTitle(t('user.user'))

const username = route.params.username as string

let lastItemId = 0

const {
  loading: userLoading,
  data: user,
  error: userError,
  send: loadUser,
} = useRequest(() => getUserDetailByUsername(username)).onSuccess(() => {
  setTitle(user.value?.display_name)
  loadTopics()
})

const {
  loading: topicsLoading,
  data: topics,
  isLastPage,
  error: topicsError,
  send: loadTopics,
} = usePagination(
  (page, limit) => getTopicsByUsername(lastItemId, limit, username),
  {
    append: true,
    initialPageSize: 10,
    immediate: false,
  },
).onSuccess(() => {
  const items = topics.value
  if (!items) return

  lastItemId = items[items.length - 1].id
})

onActivated(() => {
  if (user.value?.display_name) {
    setTitle(user.value.display_name)
  }
})
</script>
