<template>
  <Navbar :is-login="user.isLogin"></Navbar>
  <main id="_flat">
    <RouterView />
  </main>
</template>

<script setup lang="ts">
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
import { useUserStore, useTheme } from "./stores";

const user = useUserStore();
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
</style>
