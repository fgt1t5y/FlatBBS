<template>
  <Navbar :is-login="user.isLogin" />
  <main id="_flat">
    <RouterView />
    <div v-if="false" class="edit-window">
      <Editor v-model:value="topicDraft.content" />
    </div>
  </main>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue'
import { useUserInfoStore, useTheme } from './stores'
import Editor from './components/Editor.vue'
import { reactive } from 'vue'
import Cookies from 'js-cookie'
import './App.css'

const user = useUserInfoStore()
const topicDraft = reactive({
  title: '',
  content: '',
})
useTheme()

if (Cookies.get('flat_sess')) {
  user.fetch()
}
</script>
