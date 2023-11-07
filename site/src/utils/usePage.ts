import { computed } from 'vue';
import { useRouter } from 'vue-router';

export const usePage = () => {
  const router = useRouter();
  const path = computed(() => {
    return router.currentRoute.value.fullPath;
  });
  const goHome = (replace: boolean) => {
    if (replace) {
      router.replace({ path: '/' });
      return;
    }
    router.push({ path: '/' });
    return;
  };
  const back = () => {
    if (!history.state.back) {
      router.push({ path: '/' });
      return;
    }
    router.back();
  };

  return { back, goHome, path };
};
