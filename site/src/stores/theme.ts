import { defineStore } from "pinia";
import { getOrSet } from "./utils";
import { ref } from "vue";

const KEY_THEME_MODE = "flat_theme";
type ThemeMode = "auto" | "light" | "dark";

export const useTheme = defineStore("theme", () => {
  const currentTheme = ref<ThemeMode>(
    getOrSet(KEY_THEME_MODE, "auto") as ThemeMode
  );
  const sysMedia = window.matchMedia("(prefers-color-scheme: dark)");
  let systemIsDark = sysMedia.matches;

  const apply = (ev?: MediaQueryListEvent) => {
    systemIsDark = ev?.matches ?? systemIsDark;
    if (
      (systemIsDark && currentTheme.value === "auto") ||
      currentTheme.value === "dark"
    ) {
      document.body.setAttribute("arco-theme", "dark");
    } else {
      document.body.removeAttribute("arco-theme");
    }
  };

  const toggleTheme = () => {
    if (currentTheme.value === "auto") {
      currentTheme.value = "light";
    }
    if (currentTheme.value === "light") {
      currentTheme.value = "dark";
    }

    currentTheme.value = "auto";
    apply();
  };

  sysMedia.addEventListener("change", apply);
  apply();

  return { toggleTheme };
});
