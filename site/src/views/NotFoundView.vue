<template>
  <MainContent disable-panels>
    <div class="flex flex-col items-center gap-8 my-6">
      <h2 class="text-3xl">页面不存在</h2>
      <button class="btn btn-primary btn-md" @click="page.goHome(false)">
        回到首页
      </button>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import { usePage } from '@/utils'

const page = usePage()
</script>
