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
        <Popover
          v-if="isLogin"
          :popup-visible="userMenuShow"
          position="br"
          trigger="click"
          content-class="user-menu"
        >
          <Avatar
            :size="32"
            :image-url="user.info.avatar_uri"
            @click="userMenuShow = true"
          />
          <template #content>
            <header>
              <Avatar :size="56" :image-url="user.info.avatar_uri" />
              <div class="user-menu-info">
                <TypographyTitle :heading="5">{{
                  user.info.username
                }}</TypographyTitle>
                <TypographyText type="secondary">{{
                  user.info.email
                }}</TypographyText>
              </div>
            </header>
            <Divider />
            <main>
              <Doption
                v-for="options in userMenuOptions"
                @click="options.action"
              >
                <div>{{ options.text }}</div>
              </Doption>
            </main>
          </template>
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
  TypographyText,
  Input,
  Button,
  Space,
  Avatar,
  Popover,
  Doption,
  Divider,
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

interface UserMenuOptionsProps {
  text: string;
  action: (ev?: MouseEvent) => void;
}

const props = withDefaults(defineProps<NavbarProps>(), {
  isLogin: false,
});

const user = useUserStore();
const userMenuShow = ref<boolean>(false);

const userMenuOptions = [
  {
    text: "设置",
    action: () => {
      console.log("click");
      userMenuShow.value = !userMenuShow.value;
    },
  },
  {
    text: "退出登录",
  },
] as UserMenuOptionsProps[];
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

.user-menu {
  min-width: 300px;
  max-width: 40vw;
  padding: 8px !important;
}

.user-menu .arco-avatar {
  margin-right: 0.7rem;
}

.user-menu header {
  display: flex;
  padding: 0px 12px;
}

.user-menu main {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.user-menu-info {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
}

.user-menu-info h5 {
  margin: unset;
}
</style>
