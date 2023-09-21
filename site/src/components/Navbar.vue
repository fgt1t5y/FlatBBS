<template>
  <nav class="nav">
    <RouterLink to="/" class="nav-brand">
      <TypographyTitle :heading="5">Flat BBS</TypographyTitle>
    </RouterLink>
    <Space class="nav-opt">
      <Button class="mob_hidden">
        <template #icon>
          <IconSearch />
        </template>
      </Button>
      <Input placeholder="搜索...">
        <template #prefix>
          <IconSearch />
        </template>
      </Input>
      <RouterLink to="/auth">
        <Button type="primary">注册 / 登录</Button>
      </RouterLink>
    </Space>
  </nav>
</template>

<script setup lang="ts">
import { TypographyTitle, Input, Button, Space } from "@arco-design/web-vue";
import { IconSearch } from "@arco-design/web-vue/es/icon";
import { RouterLink } from "vue-router";
</script>

<style>
.nav {
  height: 45px;
  padding: 0px 16px;
  display: flex;
  align-items: center;
  position: sticky;
  top: 0px;
  background-color: var(--color-bg-2);
  justify-content: space-between;
  border-bottom: 1px solid var(--color-border);
}

.nav-brand {
  text-decoration: none;
  display: flex;
  align-self: center;
}

.nav-brand h5 {
  margin: unset;
}
</style>
