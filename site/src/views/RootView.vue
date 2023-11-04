<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/" class="site-brand">
        <SiteLogo />
        <span>Flat BBS</span>
      </RouterLink>
      <RouterLink to="/" class="sider-link link">
        <IconHome />
        <span>首页</span>
      </RouterLink>
      <RouterLink to="/search" class="sider-link link">
        <IconSearch />
        <span>搜索</span>
      </RouterLink>
      <RouterLink v-if="user.isLogin" to="/settings" class="sider-link link">
        <IconSettings />
        <span>设置</span>
      </RouterLink>
      <RouterLink v-else to="/auth" class="sider-link link">
        <IconUser />
        <span>注册 / 登录</span>
      </RouterLink>
      <TypographyText type="secondary" class="sider-group">
        论坛版块
      </TypographyText>
      <BoardList />
    </template>
    <template #content>
      <RouterView v-slot="{ Component }">
        <KeepAlive exclude="SettingsView" :max="10">
          <component :is="Component" />
        </KeepAlive>
      </RouterView>
    </template>
    <template #panels>
      <div class="global-search-bar">
        <Input
          ref="inputRef"
          :max-length="64"
          placeholder="搜索..."
          size="large"
        >
          <template #suffix>
            <kbd>^K</kbd>
          </template>
        </Input>
      </div>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import SiteLogo from '@/components/SiteLogo.vue'
import { useUserStore } from '@/stores'
import { TypographyText, Input } from '@arco-design/web-vue'
import {
  IconHome,
  IconSettings,
  IconSearch,
  IconUser,
} from '@arco-design/web-vue/es/icon'
import { onMounted, ref } from 'vue'
import { RouterLink } from 'vue-router'

const user = useUserStore()
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
