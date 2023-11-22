import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

interface FetchDataOptions {
  limit: number;
}

export const useFetchData = <T>(
  fetcher: (...arg: any[]) => Promise<AxiosResponse>,
  onSuccess: (data: T) => void,
  options?: FetchDataOptions,
) => {
  const { limit } = options ?? { limit: 1 };
  const noMore = ref<boolean>(false);
  const isLoading = ref<boolean>(false);
  const isSuccess = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  let data = null as T;
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
        data = res.data.data!;
        if (Array.isArray(data) && data.length < limit) noMore.value = true;
        onSuccess && onSuccess(data);
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

  return { isFailed, isLoading, isSuccess, noMore, fetch, retry };
};
