import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

export const useFetchData = <T>(
  fetcher: (...arg: any[]) => Promise<AxiosResponse>,
) => {
  const isLoading = ref<boolean>(false);
  const isSuccess = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const data = ref<T>();
  let lastArgv = [] as any[];
  const fetch = (...argv: Parameters<typeof fetcher>) => {
    if (isLoading.value) return;
    isLoading.value = true;
    isSuccess.value = false;
    isFailed.value = false;
    lastArgv = [...argv];
    fetcher(...argv)
      .then((res) => {
        if (res.data.code > window.$code.OK) {
          isFailed.value = true;
          return;
        }
        isSuccess.value = true;
        data.value = res.data.data!;
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        isLoading.value = false;
      });
  };
  const retry = () => {
    fetch(...lastArgv);
  };

  return { isFailed, isLoading, isSuccess, data, fetch, retry };
};
