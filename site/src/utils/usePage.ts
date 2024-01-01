import router from '@/router';

export const usePage = () => {
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

  return { back, go, goHome };
};
