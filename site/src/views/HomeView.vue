<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <SiteLogo class="mob-show" />
  </PageTitle>
  <TopicList />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import PageTitle from '@/components/PageTitle.vue'
import SiteLogo from '@/components/SiteLogo.vue'
</script>
