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
import { useUserStore, useTheme } from './stores'
import Editor from './components/Editor.vue'
import { reactive } from 'vue'
import Cookies from 'js-cookie'

const user = useUserStore()
const topicDraft = reactive({
  title: '',
  content: '',
})
useTheme()

if (Cookies.get('flat_sess')) {
  user.login()
}
</script>

<style>
#_flat {
  margin: 16px auto;
  max-width: var(--page-max-width);
}

.edit-window {
  position: absolute;
  bottom: 0px;
  left: 0px;
  right: 0px;
  max-width: var(--page-max-width);
  z-index: 100;
  margin: 0px auto;
}
</style>
