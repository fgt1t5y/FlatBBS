<template>
  <PageTitle title="全部话题">
    <span class="mob-hidden">全部话题</span>
    <RouterLink to="/" class="mob-show">
      <NText type="primary">FlatBBS</NText>
    </RouterLink>
  </PageTitle>
  <TopicEditor v-if="route.params.id" @success="refreshTopicList" />
  <TopicList ref="topicListRef" :board="Number(route.params.id ?? 0)" />
</template>

<script setup lang="ts">
import TopicList from '@/components/TopicList.vue'
import TopicEditor from '@/components/TopicEditor.vue'
import PageTitle from '@/components/PageTitle.vue'
import { NText } from 'naive-ui'
import { ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const topicListRef = ref<InstanceType<typeof TopicList>>()
const refreshTopicList = () => {
  topicListRef.value!.refresh()
}
</script>
