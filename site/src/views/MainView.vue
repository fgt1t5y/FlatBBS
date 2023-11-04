<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/">
        <TypographyTitle :heading="5" class="site-brand">Flat BBS</TypographyTitle>
      </RouterLink>
      <RouterLink to="/" class="sider-link link">
        <IconHome />
        <span>首页</span>
      </RouterLink>
      <RouterLink to="/settings" class="sider-link link">
        <IconHome />
        <span>首页</span>
      </RouterLink>
      <TypographyText type="secondary" class="sider-group">
        论坛版块
      </TypographyText>
      <BoardList />
    </template>
    <template #content>
      <RouterView />
    </template>
    <template #panels>
      <Input
        ref="inputRef"
        class="mob-hidden"
        :max-length="64"
        placeholder="搜索..."
      >
        <template #suffix>
          <kbd>^K</kbd>
        </template>
      </Input>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import { TypographyText, Input, TypographyTitle } from '@arco-design/web-vue'
import { IconHome } from '@arco-design/web-vue/es/icon'
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'

const inputRef = ref<InstanceType<typeof Input>>()
const focusInput = (ev: KeyboardEvent) => {
  if (ev.key === 'k' && ev.ctrlKey) {
    ev.preventDefault()
    inputRef.value?.focus()
  }
}

onMounted(() => {
  document.addEventListener('keydown', focusInput)
})
</script>
