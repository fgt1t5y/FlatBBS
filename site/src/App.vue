<template>
  <Navbar></Navbar>
  <main id="_flat">
    <RouterView />
  </main>
</template>

<script setup lang="ts">
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
import { useUserStore } from "./stores/user";

const user = useUserStore();

console.log(1);
user.loadUserInfo();
</script>

<style>
body {
  background-color: var(--color-bg-1);
  color: var(--color-text-2);
}

#_flat {
  margin: 16px auto;
  max-width: 960px;
}
</style>
