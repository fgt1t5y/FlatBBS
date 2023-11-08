import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

export const useFetchData = <T>(
  fetcher: (...arg: any) => Promise<AxiosResponse>,
  onfinish: (data: T) => any,
  ...argv: any[]
) => {
  const isLoading = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const isEmpty = ref<boolean>(false);
  let data = null as T;
  const fetch = () => {
    isLoading.value = true;
    isFailed.value = false;
    fetcher(...argv)
      .then((res) => {
        if (res.data.code === window.$code.OK) {
          data = res.data.data!;
          if (Array.isArray(data) && !data.length) {
            isEmpty.value = true;
          }
        }
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        onfinish(data);
        isLoading.value = false;
      });
  };
  const retry = () => {
    fetch();
  };

  return { isFailed, isLoading, data, fetch, retry };
};
