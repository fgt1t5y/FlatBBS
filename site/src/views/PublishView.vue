<template>
  <MainContentVue>
    <PageTitle title="发布">
      <template #extra>
        <NButton type="primary" round>发布</NButton>
      </template>
    </PageTitle>
    <div class="chunk">
      <TopicEditor />
    </div>
  </MainContentVue>
</template>

<script setup lang="ts">
import MainContentVue from '@/components/MainContent.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NButton } from 'naive-ui'
</script>
