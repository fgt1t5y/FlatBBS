import router from '@/router';
import { computed } from 'vue';

export const usePage = () => {
  const path = computed(() => {
    return router.currentRoute.value.fullPath;
  });
  const go = (path: string, replace?: boolean) => {
    console.log(router);
    if (replace) {
      router.replace({ path: path });
      return;
    }
    router.push({ path: '/' });
    return;
  };
  const goHome = (replace: boolean) => {
    go('/', replace);
  };
  const back = () => {
    if (!history.state.back) {
      router.push({ path: '/' });
      return;
    }
    router.back();
  };

  return { back, go, goHome, path };
};
