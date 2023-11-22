import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

interface FetchDataOptions {
  limit: number;
}

const defaultOptions: FetchDataOptions = {
  limit: 10,
};

export const useFetchList = <T>(
  fetcher: (...arg: any[]) => Promise<AxiosResponse>,
  options?: FetchDataOptions,
) => {
  const { limit } = options ?? defaultOptions;
  const noMore = ref<boolean>(false);
  const isLoading = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const data = ref<any>([]);
  let lastId = 0;
  const fetch = (unit_id: number) => {
    if (isLoading.value) return;
    isLoading.value = true;
    isFailed.value = false;
    fetcher(lastId, limit, unit_id)
      .then((res) => {
        if (res.data.code > window.$code.OK) {
          isFailed.value = true;
          return;
        }
        if ((res.data.data as T[]).length < limit) noMore.value = true;
        data.value.push(...res.data.data!);
        lastId = data.value[data.value.length - 1].id;
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        isLoading.value = false;
      });
  };

  return { isFailed, isLoading, noMore, data, fetch };
};
