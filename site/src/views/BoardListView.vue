<template>
  <MainContent>
    <PageTitle title="所有板块" :show-back="false" />
    <CommonList>
      <div v-for="board in boards" class="item flex-v gap align-center">
        <NAvatar :src="board.avatar_uri" :size="35" />
        <RouterLink :to="`/board/${board.slug}`">
          <div class="f-m">{{ board.name }}</div>
        </RouterLink>
      </div>
      <RequestPlaceholder
        :is-loading="loading"
        :is-failed="!!error"
        :no-more="true"
        @retry="send"
      />
    </CommonList>
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
