<template>
  <PageTitle title="搜索" />
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
import { InputSearch } from '@arco-design/web-vue'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import '@/style/SearchView.css'
import PageTitle from '@/components/PageTitle.vue'

const route = useRoute()
const searchValue = ref<string>((route.query.q as string) ?? '')
const inputRef = ref<InstanceType<typeof InputSearch>>()

onMounted(() => {
  // inputRef.value!.focus()
})
</script>
