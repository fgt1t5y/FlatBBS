<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <RouterLink to="/" class="mob-show">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicEditor />
  <TopicList />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText } from 'naive-ui'
</script>
