<template>
  <MainContentVue class="item">
    <div class="item">
      <NH4>发布话题</NH4>
      <TopicEditor />
    </div>
  </MainContentVue>
</template>

<script setup lang="ts">
import MainContentVue from '@/components/MainContent.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import { NH4 } from 'naive-ui'
</script>
