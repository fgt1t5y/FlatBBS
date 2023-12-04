<template>
  <MainContentVue>
    <div class="title">
      <NH3>
        <NText type="primary">发布话题</NText>
      </NH3>
    </div>
    <div class="chunk">
      <TopicEditor />
    </div>
  </MainContentVue>
</template>

<script setup lang="ts">
import MainContentVue from '@/components/MainContent.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import { NH3, NText } from 'naive-ui'
</script>
