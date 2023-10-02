import { defineStore } from "pinia";
import { getOrSet, set } from "./utils";
import { ref } from "vue";

const KEY_THEME_MODE = "flat_theme";
type ThemeMode = "auto" | "light" | "dark";

export const useTheme = defineStore("theme", () => {
  const isInited = ref<boolean>(false);
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

  const applyAndSava = () => {
    set(KEY_THEME_MODE, currentTheme.value);
    console.log(currentTheme.value);
    apply();
  };

  !isInited.value && sysMedia.addEventListener("change", apply);
  !isInited.value && apply();
  isInited.value = true;

  const toggleTheme = () => {
    if (currentTheme.value === "auto") {
      currentTheme.value = "light";
      applyAndSava();
      return;
    }
    if (currentTheme.value === "light") {
      currentTheme.value = "dark";
      applyAndSava();
      return;
    }
    if (currentTheme.value === "dark") {
      currentTheme.value = "auto";
      applyAndSava();
      return;
    }
  };

  return { toggleTheme };
});
