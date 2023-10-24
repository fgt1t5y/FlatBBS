<template>
  <div class="topic-list">
    <List :bordered="false">
      <ListItem v-for="item in topicsRaw" :key="item.id">
        <div class="topic-title">{{ item.title }}</div>
      </ListItem>
    </List>
  </div>
</template>

<script setup lang="ts">
import { getTopicList } from '@/services/topics'
import '@/style/TopicList.css'
import { ref, onMounted, watch } from 'vue'
import type { Topic } from '@/types'
import { useRoute } from 'vue-router'
import { List, ListItem } from '@arco-design/web-vue'

defineOptions({
  name: 'TopicList',
})

const topicsRaw = ref<Topic[] | null>(null)
const route = useRoute()
const fetchTopics = () => {
  getTopicList(0, 2).then((res) => {
    topicsRaw.value = res.data.data!
  })
}

watch(
  () => route.params.id,
  (board_id) => {
    console.log(board_id)
  },
)

onMounted(() => {
  fetchTopics()
})
</script>
