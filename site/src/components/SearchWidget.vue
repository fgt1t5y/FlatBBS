<template>
  <div class="search-widget">
    <NTabs type="line">
      <NTabPane name="topics" label="话题"></NTabPane>
      <NTabPane name="boards" label="版块"></NTabPane>
      <NTabPane name="users" label="用户"></NTabPane>
    </NTabs>
  </div>
</template>

<script setup lang="ts">
import { NTabs, NTabPane } from 'naive-ui'

defineOptions({
  name: 'SearchWidget',
})
</script>
