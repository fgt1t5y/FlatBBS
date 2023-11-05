<template>
  <main id="flatbbs">
    <RouterView />
    <div v-show="editorWindow.show" class="editor-window mob-hidden">
      <div class="editor-window-header">
        <input
          id="topic-title-input"
          v-model="topicDraft.title"
          type="text"
          placeholder="话题标题"
          maxlength="63"
        />
        <Button type="primary" title="发布话题">
          <template #icon>
            <IconCheck />
          </template>
          发布
        </Button>
        <button
          class="icon-link hover-card"
          title="最小化编辑器"
          @click="editorWindow.minWindow"
        >
          <IconDown :size="18" />
        </button>
        <button
          class="icon-link hover-card"
          title="保存草稿并关闭编辑器"
          @click="editorWindow.hiddenWindow"
        >
          <IconClose :size="18" />
        </button>
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
  </main>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme, useEditorWindow } from './stores'
import Editor from './components/Editor.vue'
import { reactive, onMounted } from 'vue'
import { hasToken } from './utils'
import { IconDown, IconClose, IconCheck } from '@arco-design/web-vue/es/icon'
import { Button } from '@arco-design/web-vue'

const user = useUserStore()
const topicDraft = reactive({
  title: '',
  content: '',
})
const editorWindow = useEditorWindow()
useTheme()

if (hasToken()) {
  user.fetch()
}

onMounted(() => {})
</script>
