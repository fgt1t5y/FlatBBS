<template>
  <MainContent disable-panels>
    <PageTitle title="所有板块" :show-back="false" />
    <CommonList hoverable :items="boards" :is-end="true">
      <template #default="{ item }">
        <div class="item p-3 flex gap-3 items-center border-bt">
          <Avatar class="size-9" :src="item.avatar_uri" />
          <RouterLink :to="`/board/${item.slug}`">
            <div class="text-base">{{ item.name }}</div>
          </RouterLink>
        </div>
      </template>
    </CommonList>
    <RequestPlaceholder :loading="loading" :error="error" @retry="send" />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonList from '@/components/CommonList.vue'
import RequestPlaceholder from '@/components/RequestPlaceholder.vue'
import { getBoards } from '@/services'
import { usePagination } from 'alova/client'
import Avatar from '@/components/Avatar.vue'

const { data: boards, error, loading, send } = usePagination(getBoards, {})
</script>
