<template>
  <MainContent :loading="userLoading" :error="userError" @retry="loadUser">
    <PageTitle :title="user.display_name" />
    <CommonDetail
      :avatar-uri="user.avatar_uri"
      :name="user.display_name"
      :introduction="user.introduction"
      avatar-rounded
    >
      <div v-if="user.allow_login === 0" class="flex gap-2 text-muted">
        <i class="icon ti ti-ban"></i>
        <span>{{ $t('message.this_user_has_been_banned') }}</span>
      </div>
      <div class="flex gap-2 text-base">
        <span class="font-bold">{{ user.topic_count }}</span>
        <span class="text-muted">{{ $t('board.topic_count') }}</span>
      </div>
    </CommonDetail>
    <CommonRouteTabs
      :tabs="[
        {
          routeName: 'user_topics',
          label: $t('topic.topic'),
          params: { username },
        },
        {
          routeName: 'user_liked_topics',
          label: $t('topic.liked'),
          params: { username },
        },
      ]"
    />
    <RouterView v-slot="{ Component }">
      <KeepAlive :max="10">
        <component :is="Component" :key="route.fullPath" />
      </KeepAlive>
    </RouterView>
  </MainContent>
</template>

<script setup lang="ts">
import CommonDetail from '@/components/CommonDetail.vue'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonRouteTabs from '@/components/CommonRouteTabs.vue'
import { getUserDetailByUsername } from '@/services'
import { useTitle } from '@/utils'
import { useRequest } from 'alova/client'
import { onActivated } from 'vue'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'

const route = useRoute()
const { t } = useI18n()
const { setTitle } = useTitle(t('user.user'))

const username = route.params.username as string

const {
  loading: userLoading,
  data: user,
  error: userError,
  send: loadUser,
} = useRequest(() => getUserDetailByUsername(username)).onSuccess(() => {
  setTitle(user.value?.display_name)
})

onActivated(() => {
  if (user.value?.display_name) {
    setTitle(user.value.display_name)
  }
})
</script>
