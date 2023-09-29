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
        <Input ref="inputRef" :max-length="64" placeholder="搜索...">
          <template #prefix>
            <IconSearch />
          </template>
          <template #suffix>
            <kbd>/</kbd>
          </template>
        </Input>
        <Popover v-if="isLogin" position="br" trigger="click">
          <Avatar :size="32" :image-url="user.info.avatar_uri" />
          <template #content>欢迎你，{{ user.info.username }} </template>
        </Popover>
        <RouterLink to="/auth" v-else>
          <Button type="primary">注册 / 登录</Button>
        </RouterLink>
      </Space>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { useUserStore } from "@/stores";
import {
  TypographyTitle,
  Input,
  Button,
  Space,
  Avatar,
  Popover,
} from "@arco-design/web-vue";
import { IconSearch } from "@arco-design/web-vue/es/icon";
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";

defineOptions({
  name: "Navbar",
});

let inputRef = ref<InstanceType<typeof Input>>();

const focusInput = (ev: KeyboardEvent) => {
  if (ev.key === "/") {
    ev.preventDefault();
    inputRef.value?.focus();
  }
};

onMounted(() => {
  document.addEventListener("keydown", focusInput);
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
  background-color: var(--color-bg-2);
}

.nav {
  height: 45px;
  padding: 0px 16px;
  display: flex;
  align-items: center;
  position: sticky;
  top: 0px;
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
