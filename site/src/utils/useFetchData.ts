import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

export const useFetchData = <T>(
  fetcher: (...arg: any) => Promise<AxiosResponse>,
) => {
  const isLoading = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const isEmpty = ref<boolean>(false);
  let data = null as T;
  let lastArgv = [] as any[];
  let lastOnSuccess = (data: T) => data;
  const fetch = (onsuccess: (data: T) => any, ...argv: any[]) => {
    isLoading.value = true;
    isFailed.value = false;
    lastArgv = [...argv];
    console.log(lastArgv, argv, onsuccess.toString());
    lastOnSuccess = onsuccess;
    fetcher(...argv)
      .then((res) => {
        if (res.data.code === window.$code.OK) {
          data = res.data.data!;
          onsuccess(data);
          if (Array.isArray(data) && !data.length) {
            isEmpty.value = true;
          }
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
    fetch(lastOnSuccess, ...lastArgv);
  };

  return { isFailed, isLoading, data, fetch, retry };
};
