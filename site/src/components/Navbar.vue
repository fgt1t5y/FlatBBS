<template>
  <header class="nav-container">
    <nav class="nav">
      <RouterLink to="/" class="nav-brand">
        <TypographyTitle :heading="5">Flat BBS</TypographyTitle>
      </RouterLink>
      <div class="nav-opt" size="medium">
        <RouterLink to="/search" class="mob-hidden">
          <IconSearch :size="20" />
        </RouterLink>
        <Input ref="inputRef" :max-length="64" placeholder="搜索...">
          <template #prefix>
            <IconSearch />
          </template>
          <template #suffix>
            <kbd>^K</kbd>
          </template>
        </Input>
        <a class="icon-link" @click="toggleTheme">
          <IconComputer v-if="theme === 'auto'" :size="20" />
          <IconSun v-else-if="theme === 'light'" :size="20" />
          <IconMoon v-else :size="20" />
        </a>
        <Dropdown
          position="br"
          trigger="click"
          class="user-menu"
          content-class="user-menu"
        >
          <Avatar
            v-if="isLogin"
            :size="32"
            :image-url="info.avatar_uri"
            tabindex="0"
          />
          <Avatar v-else :size="32">登录</Avatar>
          <template #content>
            <header>
              <Avatar :size="56" :image-url="info.avatar_uri" />
              <div class="user-menu-info">
                <TypographyTitle :heading="5">{{
                  info.username
                }}</TypographyTitle>
                <TypographyText type="secondary">{{
                  info.email
                }}</TypographyText>
              </div>
            </header>
            <main>
              <Doption
                v-if="isLogin"
                v-for="options in userMenuOptions"
                @click="options.action"
                @keydown.enter="options.action"
                tabindex="0"
              >
                <div>{{ options.text }}</div>
              </Doption>
              <Doption v-else class="menu-link">
                <RouterLink to="/auth">登录 / 注册</RouterLink>
              </Doption>
            </main>
          </template>
        </Dropdown>
      </div>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { useTheme, useUserStore } from "@/stores";
import {
  TypographyTitle,
  TypographyText,
  Input,
  Avatar,
  Dropdown,
  Doption,
} from "@arco-design/web-vue";
import {
  IconSearch,
  IconSun,
  IconComputer,
  IconMoon,
} from "@arco-design/web-vue/es/icon";
import { onMounted, ref, watch } from "vue";
import { RouterLink } from "vue-router";

defineOptions({
  name: "Navbar",
});

interface NavbarProps {
  isLogin: boolean;
}
interface UserMenuOptionsProps {
  text: string;
  action: (ev?: MouseEvent) => void;
}

const { theme, toggleTheme } = useTheme();
const inputRef = ref<InstanceType<typeof Input>>();
const props = withDefaults(defineProps<NavbarProps>(), {
  isLogin: false,
});
const { info } = useUserStore();
const userMenuOptions = [
  {
    text: "设置",
    action: () => {
      console.log("click");
    },
  },
  {
    text: "退出登录",
  },
] as UserMenuOptionsProps[];

const focusInput = (ev: KeyboardEvent) => {
  if (ev.key === "k" && ev.ctrlKey) {
    ev.preventDefault();
    inputRef.value?.focus();
  }
};

onMounted(() => {
  document.addEventListener("keydown", focusInput);
});

watch(
  () => theme,
  (v) => {
    console.log(v);
  }
);
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

.nav-opt {
  display: flex;
  gap: 16px;
  align-items: center;
}

.user-menu .arco-dropdown {
  min-width: 300px;
  max-width: 40vw;
  padding: 8px !important;
}

.user-menu .arco-avatar {
  margin-right: 0.7rem;
}

.user-menu header {
  display: flex;
  padding: 8px 12px 0px 12px;
  margin-bottom: 12px;
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

.arco-avatar {
  aspect-ratio: 1 / 1;
}

.icon-link {
  padding: 4px;
  border-radius: 50%;
  cursor: pointer;
}

.icon-link:hover {
  background-color: var(--color-fill-2);
}

.menu-link .arco-dropdown-option-content {
  width: 100%;
}

.menu-link a,
.icon-link a {
  color: var(--color-text-1);
  text-decoration: none;
  display: block;
}

.icon-link svg {
  color: var(--color-text-1) !important;
}
</style>
