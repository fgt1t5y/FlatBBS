<template>
  <MainContentVue>
    <PageTitle title="发布" />
    <div class="chunk">
      <TopicEditor />
    </div>
  </MainContentVue>
</template>

<script setup lang="ts">
import MainContentVue from '@/components/MainContent.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
</script>
