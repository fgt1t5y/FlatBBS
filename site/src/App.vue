<template>
  <main id="flatbbs">
    <RouterView />
    <div class="editor-window">
      <div class="editor-header">
        <input
          v-model="topicDraft.title"
          type="text"
          placeholder="话题标题"
          maxlength="63"
        />
        <Button type="primary">
          <template #icon>
            <IconCheck />
          </template>
          发布
        </Button>
        <button class="icon-link hover-card">
          <IconDown :size="18" />
        </button>
        <button class="icon-link hover-card">
          <IconClose :size="18" />
        </button>
      </div>
      <Editor
        v-model:value="topicDraft.content"
        placeholder="输入话题内容...（选填）"
      />
      <div></div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import Editor from './components/Editor.vue'
import { reactive } from 'vue'
import { hasToken } from './utils'
import { IconDown, IconClose, IconCheck } from '@arco-design/web-vue/es/icon'
import { Button } from '@arco-design/web-vue'

const user = useUserStore()
const topicDraft = reactive({
  title: '',
  content: '',
})
useTheme()

if (hasToken()) {
  user.fetch()
}
</script>
