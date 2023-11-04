<template>
  <main id="flatbbs">
    <RouterView />
    <div v-if="true" class="edit-window">
      <input
        v-model="topicDraft.title"
        type="text"
        name="title"
        class="editor-title-input"
        placeholder="话题标题"
        maxlength="63"
      />
      <Editor
        v-model:value="topicDraft.content"
        placeholder="输入话题内容...（选填）"
      />
    </div>
  </main>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import { useUserStore, useTheme } from './stores'
import Editor from './components/Editor.vue'
import { reactive } from 'vue'
import { hasToken } from './utils'

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
