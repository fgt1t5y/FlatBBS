<template>
  <Button type="primary" @click="test">Hello</Button>
</template>

<script setup lang="ts">
import { useUserStore } from "@/stores/user";
import { Button } from "@arco-design/web-vue";

const user = useUserStore();

const test = () => {
  console.log(user.info.avatar_uri);
};
</script>
