<template>
  <MainContent>
    <PageTitle title="搜索">
      <NInput
        ref="inputRef"
        v-model:value="searchKeyword"
        :input-props="{ type: 'search' }"
        placeholder="搜索帖子、用户"
        size="large"
      />
    </PageTitle>
  </MainContent>
</template>

<script setup lang="ts">
import { NInput } from 'naive-ui'
import { ref, onMounted, onActivated } from 'vue'
import { useRoute } from 'vue-router'
import PageTitle from '@/components/PageTitle.vue'
import MainContent from '@/components/MainContent.vue'

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
