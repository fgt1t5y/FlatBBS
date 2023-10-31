<template>
  <div class="page-header">
    <TypographyTitle :heading="4">搜索</TypographyTitle>
  </div>
  <div class="page-chunk search-bar">
    <InputSearch
      ref="inputRef"
      :default-value="searchValue"
      placeholder="搜索帖子、用户"
      size="large"
    />
  </div>
</template>

<script setup lang="ts">
import { InputSearch, TypographyTitle } from '@arco-design/web-vue'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import '@/style/SearchView.css'

const route = useRoute()
const searchValue = ref<string>((route.query.q as string) ?? '')
const inputRef = ref<InstanceType<typeof InputSearch>>()

onMounted(() => {
  // inputRef.value!.focus()
})
</script>
