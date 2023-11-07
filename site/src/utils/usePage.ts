import { computed } from 'vue';
import { useRouter } from 'vue-router';

export const usePage = () => {
  const router = useRouter();
  const path = computed(() => {
    return router.currentRoute.value.fullPath;
  });
  const back = () => {
    if (!history.state.back) {
      router.push({ path: '/' });
      return;
    }
    router.back();
  };

  return { back, path };
};
