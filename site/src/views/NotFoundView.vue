<template>
  <NSpace vertical align="center" class="error-page">
    <div></div>
    <NH2 align-text>
      <NText type="error">页面不存在</NText>
    </NH2>
    <NButton type="error" round>首页</NButton>
  </NSpace>
</template>

<script setup lang="ts">
import { NH2, NText, NSpace, NButton } from 'naive-ui'
import '@/style/NotFound.css'
</script>
