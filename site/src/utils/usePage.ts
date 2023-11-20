import router from '@/router';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

export const usePage = () => {
  const route = useRoute();
  const path = computed(() => {
    return router.currentRoute.value.fullPath;
  });
  const boardId = computed(() => {
    return route.params.board_id ?? '0';
  });
  const go = (path: string, replace?: boolean) => {
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

  return { back, go, goHome, path, boardId };
};
