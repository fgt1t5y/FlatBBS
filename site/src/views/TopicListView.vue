<template>
  <div class="page-header">
    <TypographyTitle :heading="4">话题</TypographyTitle>
  </div>
  <TopicList />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import { TypographyTitle } from '@arco-design/web-vue'
</script>
