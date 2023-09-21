<script setup lang="ts">
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
</script>

<template>
  <Navbar></Navbar>
  <main id="_flat">
    <RouterView />
  </main>
</template>

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
