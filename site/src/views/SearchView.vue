<template>
  <PageTitle title="搜索">
    <NInput
      ref="inputRef"
      :default-value="searchKeyword"
      placeholder="搜索帖子、用户"
      size="large"
    />
  </PageTitle>
  <span>123</span>
</template>

<script setup lang="ts">
import { NInput } from 'naive-ui'
import { ref, onMounted, onActivated } from 'vue'
import { useRoute } from 'vue-router'
import '@/style/SearchView.css'
import PageTitle from '@/components/PageTitle.vue'

const route = useRoute()
const searchKeyword = ref<string>((route.query.q as string) ?? '')
const inputRef = ref<InstanceType<typeof NInput>>()

onActivated(() => {
  inputRef.value!.focus()
})

onMounted(() => {
  inputRef.value!.focus()
})
</script>
