<template>
  <CommonGrid sider-position="right">
    <template #sider></template>
    <template #content>
      <div class="page-settings">
        <TypographyTitle :heading="3">设置</TypographyTitle>
        <TypographyText
          >此页面用于调整用户名、密码与主题颜色等设置。
        </TypographyText>
        <Divider :margin="12" />
        <fieldset>
          <legend>我的资料</legend>
          <TypographyTitle :heading="5">我的资料</TypographyTitle>
        </fieldset>
      </div>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from "@/components/CommonGrid.vue";
import { TypographyTitle, TypographyText, Divider } from "@arco-design/web-vue";
</script>

<style>
.page-settings h3 {
  margin: unset;
}
</style>
