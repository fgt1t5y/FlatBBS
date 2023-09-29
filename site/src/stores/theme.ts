import { defineStore } from "pinia";
import { get, getOrSet } from "./utils";

const KEY_THEME_MODE = "flat_theme";
type ThemeMode = "auto" | "light" | "dark";

export const useTheme = defineStore("theme", () => {
  const currentTheme = getOrSet(KEY_THEME_MODE, "auto") as ThemeMode;
  const systemIsDark = window.matchMedia(
    "(prefers-color-scheme: dark)"
  ).matches;

  if ((systemIsDark && currentTheme === "auto") || currentTheme === "dark") {
    document.body.setAttribute("arco-theme", "dark");
  }
});
