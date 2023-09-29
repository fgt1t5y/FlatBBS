<template>
  <header class="nav-container">
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
        <Avatar :size="32" v-if="user.isLogin">
          <img :src="user.info.avatar_uri" alt="avatar"
        /></Avatar>
        <RouterLink to="/auth" v-else>
          <Button type="primary">注册 / 登录</Button>
        </RouterLink>
      </Space>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { useUserStore } from "@/stores/user";
import {
  TypographyTitle,
  Input,
  Button,
  Space,
  Avatar,
} from "@arco-design/web-vue";
import { IconSearch } from "@arco-design/web-vue/es/icon";
import { RouterLink } from "vue-router";

defineOptions({
  name: "Navbar",
});

interface NavbarProps {
  isLogin: boolean;
}

const props = withDefaults(defineProps<NavbarProps>(), {
  isLogin: false,
});

const user = useUserStore();
</script>

<style>
.nav-container {
  border-bottom: 1px solid var(--color-border);
}

.nav {
  height: 45px;
  padding: 0px 16px;
  display: flex;
  align-items: center;
  position: sticky;
  top: 0px;
  background-color: var(--color-bg-2);
  justify-content: space-between;
  max-width: var(--page-max-width);
  margin: 0px auto;
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
