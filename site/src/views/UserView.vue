<template>
  <MainContent :loading="userLoading" :error="userError" @retry="loadUser">
    <PageTitle :title="user.display_name" />
    <div class="p-3 flex flex-col gap-2 border-bt">
      <div class="flex justify-between items-end">
        <Avatar class="user-avatar size-16 md:size-24" :src="user.avatar_uri" />
      </div>
      <div>
        <div class="text-lg font-bold" v-text="user.display_name"></div>
        <div class="text-base text-muted" v-text="user.introduction"></div>
      </div>
      <div class="flex gap-2 text-base">
        <span class="font-bold">{{ user.topic_count }}</span>
        <span class="text-muted">{{ $t('board.topic_count') }}</span>
      </div>
      <div v-if="user.created_at" class="flex gap-2 text-muted">
        <i class="icon ti ti-user-plus"></i>
        <span>{{ formatDate(user.created_at) }}</span>
      </div>
      <div v-if="user.allow_login === 0" class="flex gap-2 text-muted">
        <i class="icon ti ti-ban"></i>
        <span>{{ $t('message.this_user_has_been_banned') }}</span>
      </div>
    </div>
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
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonRouteTabs from '@/components/CommonRouteTabs.vue'
import Avatar from '@/components/Avatar.vue'
import { getUserDetailByUsername } from '@/services'
import { useTitle, formatDate } from '@/utils'
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
