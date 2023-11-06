<template>
  <CommonGrid>
    <template #sider>
      <RouterLink to="/" class="site-brand">
        <SiteLogo />
      </RouterLink>
      <RouterLink to="/" class="sider-link link">
        <NIcon :size="20"><HomeRound /></NIcon>
        <span>首页</span>
      </RouterLink>
      <RouterLink to="/search" class="sider-link link">
        <NIcon :size="20"><SearchRound /></NIcon>
        <span>搜索</span>
      </RouterLink>
      <RouterLink v-if="user.isLogin" to="/settings" class="sider-link link">
        <NIcon :size="20"><SettingsRound /></NIcon>
        <span>设置</span>
      </RouterLink>
      <RouterLink v-else to="/auth" class="sider-link link">
        <NIcon :size="20"><PersonRound /></NIcon>
        <span>注册 / 登录</span>
      </RouterLink>
      <NText type="secondary" class="sider-group" title="论坛版块列表">
        论坛版块
      </NText>
      <BoardList />
      <NButton type="primary" @click="editorWindow.showWindow">
        发布话题
      </NButton>
    </template>
    <template #content>
      <RouterView v-slot="{ Component }">
        <KeepAlive exclude="SettingsView" :max="10">
          <component :is="Component" />
        </KeepAlive>
      </RouterView>
    </template>
    <template #panels>
      <div class="panel-chunk">
        <NInput
          ref="inputRef"
          :max-length="64"
          placeholder="搜索..."
          size="large"
        />
      </div>
    </template>
  </CommonGrid>
  <div v-show="editorWindow.show" class="editor-window mob-hidden">
    <div class="editor-window-header">
      <input
        id="topic-title-input"
        v-model="topicDraft.title"
        type="text"
        placeholder="话题标题"
        maxlength="63"
      />
      <NButton type="primary" title="发布话题">发布</NButton>
      <NButton
        secondary
        circle
        title="最小化编辑器"
        @click="editorWindow.minWindow"
      >
        <NIcon :size="18"><ArrowDownwardRound /></NIcon>
      </NButton>
      <NButton
        secondary
        circle
        title="保存草稿并关闭编辑器"
        @click="editorWindow.hiddenWindow"
      >
        <NIcon :size="18"><CloseRound /></NIcon>
      </NButton>
    </div>
    <Editor
      v-model:value="topicDraft.content"
      placeholder="输入话题内容...（选填）"
    />
  </div>
  <div v-show="editorWindow.isMin" class="editor-window">
    <button @click="editorWindow.showWindow">
      正在编辑话题，点击展开编辑器
    </button>
  </div>
</template>

<script setup lang="ts">
import BoardList from '@/components/BoardList.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import SiteLogo from '@/components/SiteLogo.vue'
import { useUserStore, useEditorWindow } from '@/stores'
import { NText, NButton, NInput, useMessage, NIcon } from 'naive-ui'
import {
  ArrowDownwardRound,
  HomeRound,
  CloseRound,
  SearchRound,
  SettingsRound,
  PersonRound,
} from '@vicons/material'
import { onMounted, ref, reactive } from 'vue'
import { RouterLink } from 'vue-router'
import Editor from '@/components/Editor.vue'

const topicDraft = reactive({
  title: '',
  content: '',
})
const user = useUserStore()
const editorWindow = useEditorWindow()
window.$message = useMessage()
const inputRef = ref<InstanceType<typeof NInput>>()
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
