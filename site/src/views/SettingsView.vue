<template>
  <CommonGrid sider-position="right">
    <template #sider></template>
    <template #content>
      <div class="page-settings">
        <TypographyTitle :heading="3">设置</TypographyTitle>
      </div>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from "@/components/CommonGrid.vue";
import {
  TypographyTitle,
  TypographyText,
  Divider,
  Button,
} from "@arco-design/web-vue";
</script>

<style>
.page-settings h3 {
  margin: unset;
}
</style>
