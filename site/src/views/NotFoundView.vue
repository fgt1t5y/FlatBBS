<template>
  <MainContent disable-panels>
    <div class="flex flex-col items-center gap-8 my-6">
      <h2 class="text-3xl text-red-500">页面不存在</h2>
      <NButton type="error" round @click="page.goHome(false)">首页</NButton>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import { NButton } from 'naive-ui'
import { usePage } from '@/utils'

const page = usePage()
</script>
