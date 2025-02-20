import { defineStore } from 'pinia';
import { getOrSet, set } from '@/utils';
import { computed, ref } from 'vue';
import type { ThemeMode } from '@/types';

const KEY_THEME_MODE = 'flat_theme';

export const useTheme = defineStore('theme', () => {
  const currentTheme = ref<ThemeMode>(
    getOrSet(KEY_THEME_MODE, 'auto') as ThemeMode,
  );
  const theme = computed(() => {
    return currentTheme;
  });
  const sysMedia = window.matchMedia('(prefers-color-scheme: dark)');
  let systemIsDark = sysMedia.matches;

  const apply = (ev?: MediaQueryListEvent) => {
    systemIsDark = ev?.matches ?? systemIsDark;
    if (
      (systemIsDark && currentTheme.value === 'auto') ||
      currentTheme.value === 'dark'
    ) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  };

  const init = () => {
    sysMedia.addEventListener('change', apply);
    apply();
  };

  const applyAndSava = () => {
    set(KEY_THEME_MODE, currentTheme.value);
    apply();
  };

  const switchTo = (name: ThemeMode) => {
    currentTheme.value = name;
    return applyAndSava();
  };

  return { theme, init, switchTo };
});
