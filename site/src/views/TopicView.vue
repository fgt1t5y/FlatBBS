<template>
  <PageTitle title="话题" />
  <div v-for="i in discussions">{{ i.content }}</div>
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="retry">重试</NButton>
  </div>
</template>

<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions } from '@/services/discussions'
import type { Discussion } from '@/types'
import { onMounted, ref } from 'vue'
import { useFetchData } from '@/utils/useFetchData'
import { NSpin, NButton } from 'naive-ui'
import { useRoute } from 'vue-router'

const route = useRoute()
const discussions = ref<Discussion[]>()
const { isFailed, isLoading, fetch, retry } = useFetchData<Discussion[]>(
  getDiscussions,
  (data) => {
    discussions.value = data
  },
)

onMounted(() => {
  fetch(Number(route.params.id))
})
</script>
