<template>
  <MainContent disable-panels :title="$t('page.boards')">
    <PageTitle :title="$t('page.boards')" :show-back="false" />
    <CommonList
      :items="boards"
      :is-end="true"
      :loading="loading"
      :error="error"
      @retry="send"
    >
      <template #default="{ item }">
        <div class="item p-3 flex gap-2 items-center">
          <Avatar class="size-9" :src="item.avatar_uri" />
          <RouterLink :to="{ name: 'board', params: { slug: item.slug } }">
            <div class="text-base">{{ item.name }}</div>
          </RouterLink>
        </div>
      </template>
    </CommonList>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonList from '@/components/CommonList.vue'
import { getAllBoards } from '@/services'
import { usePagination } from 'alova/client'
import Avatar from '@/components/Avatar.vue'

const { data: boards, error, loading, send } = usePagination(getAllBoards)
</script>
