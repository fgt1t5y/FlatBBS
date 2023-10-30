<template>
  <div class="page-header">
    <TypographyTitle :heading="4">搜索</TypographyTitle>
  </div>
  <div class="page-chunk search-bar">
    <InputSearch
      :default-value="searchValue"
      placeholder="搜索帖子、用户"
      size="large"
      @input="console.log(1)"
    />
  </div>
</template>

<script setup lang="ts">
import { InputSearch, TypographyTitle } from '@arco-design/web-vue'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import '@/style/SearchView.css'

const route = useRoute()
const searchValue = ref<string>((route.query.q as string) ?? '')
</script>
