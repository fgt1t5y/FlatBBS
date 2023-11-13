import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

export const useFetchData = <T>(
  fetcher: (...arg: any[]) => Promise<AxiosResponse>,
  onSuccess: (data: T) => void,
) => {
  const isLoading = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  let data = null as T;
  let lastArgv = [] as any[];
  const fetch = (...argv: Parameters<typeof fetcher>) => {
    if (isLoading.value) return;
    isLoading.value = true;
    isFailed.value = false;
    lastArgv = [...argv];
    fetcher(...argv)
      .then((res) => {
        if (res.data.code === window.$code.OK) {
          data = res.data.data!;
          onSuccess && onSuccess(data);
          return data;
        }
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

  return { isFailed, isLoading, fetch, retry };
};
