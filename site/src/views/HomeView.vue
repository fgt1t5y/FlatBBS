<template>
  <CommonGrid>
    <template #sider>123</template>
    <template #content>456</template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from "@/components/CommonGrid.vue";
import { useUserStore } from "@/stores";

const user = useUserStore();
</script>
