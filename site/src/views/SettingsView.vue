<template>
  <CommonGrid>
    <template #sider>g2</template>
    <template #content>
      <TypographyTitle :heading="3">设置</TypographyTitle>
      <Divider />
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from "@/components/CommonGrid.vue";
import { TypographyTitle, Divider } from "@arco-design/web-vue";
</script>

<style></style>
