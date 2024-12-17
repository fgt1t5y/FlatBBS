<template>
  <MainContent :loading="userLoading" :error="userError" @retry="loadUser">
    <PageTitle :title="user.display_name" />
    <CommonDetail
      :avatar-uri="user.avatar_uri"
      :name="user.display_name"
      :introduction="user.introduction"
      avatar-rounded
    />
  </MainContent>
</template>

<script setup lang="ts">
import CommonDetail from '@/components/CommonDetail.vue'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
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
