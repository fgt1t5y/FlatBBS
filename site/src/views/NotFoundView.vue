<template>
  <MainContent>
    <NSpace vertical align="center" class="error-page" style="margin-top: 5rem">
      <div></div>
      <NH2 align-text>
        <NText type="error">页面不存在</NText>
      </NH2>
      <NText>这里似乎什么都没有</NText>
      <NButton type="error" round @click="page.goHome(false)">首页</NButton>
    </NSpace>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import { NH2, NText, NSpace, NButton } from 'naive-ui'
import { usePage } from '@/utils'

const page = usePage()
</script>
