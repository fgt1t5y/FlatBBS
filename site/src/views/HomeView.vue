<template>
  <Button type="primary" @click="test">Hello</Button>
</template>

<script setup lang="ts">
import { Button } from "@arco-design/web-vue";
import { login } from "@/services/auth";

const test = () => {
  login("fgt1t5y@163.com", "");
};
</script>
