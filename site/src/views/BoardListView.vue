<template>
  <MainContent>
    <PageTitle title="所有板块" :show-back="false" />
    <CommonList :items="boards" :is-end="true">
      <template #default="{ item }">
        <div class="item flex-v gap align-center">
          <NAvatar :src="item.avatar_uri" :size="35" />
          <RouterLink :to="`/board/${item.slug}`">
            <div class="f-m">{{ item.name }}</div>
          </RouterLink>
        </div>
      </template>
    </CommonList>
    <RequestPlaceholder
      :loading="loading"
      :error="error"
      @retry="send"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonList from '@/components/CommonList.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import { getBoards } from '@/services'
import { NAvatar } from 'naive-ui'
import { usePagination } from '@alova/scene-vue'

const { data: boards, error, loading, send } = usePagination(getBoards, {})
</script>
