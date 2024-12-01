<template>
  <MainContent>
    <PageTitle title="搜索">
      <FormKit v-model="searchKeyword" type="search" placeholder="Search..." />
    </PageTitle>
  </MainContent>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'
import { FormKit } from '@formkit/vue'

const route = useRoute()
const searchKeyword = ref<string>((route.query.q as string) ?? '')
</script>
