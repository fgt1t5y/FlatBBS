<template>
  <MainContent :title="$t('page.search')">
    <PageTitle :title="$t('page.search')">
      <input v-model="searchKeyword" type="search" class="input" />
    </PageTitle>
  </MainContent>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'

const route = useRoute()
const searchKeyword = ref<string>((route.query.q as string) ?? '')
</script>
