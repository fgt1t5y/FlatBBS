<template>
  <Navbar :is-login="user.isLogin"></Navbar>
  <main id="_flat">
    <RouterView />
    <div class="edit-window">
      <TopicEditor v-model:value="topicDraft.content" />
    </div>
  </main>
</template>

<script setup lang="ts">
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
import { useUserStore, useTheme } from "./stores";
import TopicEditor from "./components/TopicEditor.vue";
import { reactive } from "vue";

const user = useUserStore();
const topicDraft = reactive({
  title: "",
  content: "",
});
useTheme();

if (user.hasToken) {
  user.loadUserInfo();
}
</script>

<style>
body {
  background-color: var(--color-bg-1);
  color: var(--color-text-2);
}

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
