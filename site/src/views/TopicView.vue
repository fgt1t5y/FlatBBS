<template>
  <PageTitle title="话题" />
  <ul>
    <li v-for="item in discussions">{{ item.content }}</li>
  </ul>
  <div class="row-center">
    <NSpin v-if="isLoading" :size="32" />
    <NButton v-if="isFailed" type="primary" @click="fetchDiscussions">
      重试
    </NButton>
  </div>
</template>

<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue'
import { getDiscussions } from '@/services/discussions'
import type { Discussion } from '@/types'
import { NSpin, NButton } from 'naive-ui'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const discussions = ref<Discussion[] | null>(null)
const isLoading = ref<boolean>(false)
const isFailed = ref<boolean>(false)
const route = useRoute()
const fetchDiscussions = () => {
  isLoading.value = true
  isFailed.value = false
  getDiscussions(Number(route.params.id))
    .then((res) => {
      if (res.data.code === window.$code.OK) {
        discussions.value = res.data.data!
      }
    })
    .catch(() => {
      isFailed.value = true
    })
    .finally(() => {
      isLoading.value = false
    })
}

onMounted(() => {
  fetchDiscussions()
})
</script>
