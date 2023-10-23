<template>
  <div class="topic-list">
    <div v-for="item in placeholderTopics" class="topic-item hover-card">
      <div class="topic-title">{{ item.title }}</div>
      <div class="topic-preview">{{ item.content }}</div>
    </div>
    <Button @click="fetch">TEST</Button>
  </div>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services/topics'
import '@/style/TopicList.css'
import { useTitle } from '@/utils/useTitle'
import { Button } from '@arco-design/web-vue'
import { onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

defineOptions({
  name: 'TopicList',
})

interface TopicProps {
  title: string
  content: string
}

const placeholderTopics = [
  {
    title: '这是第一条主题',
    content: '这是第一条主题的内容。',
  },
  {
    title: '这是第二条主题',
    content: '这是第二条主题的内容。',
  },
  {
    title: '这是第三条主题',
    content: '这是第三条主题的内容。',
  },
] as TopicProps[]
const route = useRoute()
const { setTitle } = useTitle('版块')
const fetch = () => {
  getTopicList(0, 2).then((res) => {
    console.log(res.data)
  })
}

watch(
  () => route.params.id,
  (board_id) => {
    console.log(board_id)
  },
)

onMounted(() => {
  console.log(route.params.id)
})
</script>
