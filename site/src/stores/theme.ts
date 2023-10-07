import { defineStore } from 'pinia';
import { getOrSet, set } from './utils';
import { computed, ref } from 'vue';

const KEY_THEME_MODE = 'flat_theme';
type ThemeMode = 'auto' | 'light' | 'dark';

export const useTheme = defineStore('theme', () => {
  const isInited = ref<boolean>(false);
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
      document.body.setAttribute('arco-theme', 'dark');
    } else {
      document.body.removeAttribute('arco-theme');
    }
  };

  if (!isInited.value) {
    sysMedia.addEventListener('change', apply);
    apply();
  }
  isInited.value = true;

  const applyAndSava = () => {
    set(KEY_THEME_MODE, currentTheme.value);
    apply();
  };

  const toggleTheme = () => {
    if (currentTheme.value === 'auto') {
      currentTheme.value = 'light';
      return applyAndSava();
    }
    if (currentTheme.value === 'light') {
      currentTheme.value = 'dark';
      return applyAndSava();
    }
    if (currentTheme.value === 'dark') {
      currentTheme.value = 'auto';
      return applyAndSava();
    }
  };

  return { theme, toggleTheme };
});
