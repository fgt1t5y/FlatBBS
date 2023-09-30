<template>
  <div class="topic-list">
    <div v-for="item in placeholderTopics" class="topic-item">
      <div class="topic-title">{{ item.title }}</div>
      <div class="topic-preview">{{ item.content }}</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { watch, onMounted } from "vue";
import { useRoute } from "vue-router";

defineOptions({
  name: "TopicList",
});

interface TopicProps {
  title: string;
  content: string;
}

const placeholderTopics = [
  {
    title: "这是第一条主题",
    content: "这是第一条主题的内容。",
  },
  {
    title: "这是第二条主题",
    content: "这是第二条主题的内容。",
  },
  {
    title: "这是第三条主题",
    content: "这是第三条主题的内容。",
  },
] as TopicProps[];
const route = useRoute();

watch(
  () => route.path,
  (v) => {
    console.log(v);
  }
);

onMounted(() => {
  console.log("Be Mounted.");
});
</script>

<style>
.topic-item {
  padding: 8px;
  border-radius: var(--border-radius-small);
  transition: background 0.1s;
}

.topic-item:hover {
  background-color: var(--color-neutral-2);
  cursor: pointer;
}

.topic-item .topic-title {
  font-size: 1rem;
  color: var(--color-text-1);
}

.topic-item .topic-preview {
  color: var(--color-text-3);
}
</style>
