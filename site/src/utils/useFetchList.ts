import type { AxiosResponse } from 'axios';
import { ref } from 'vue';

interface FetchDataOptions {
  limit: number;
  autoFetch: boolean;
}

const defaultOptions: FetchDataOptions = {
  limit: 10,
  autoFetch: false,
};

export const useFetchList = <T>(
  fetcher: (...arg: any[]) => Promise<AxiosResponse>,
  options?: FetchDataOptions,
) => {
  const { limit } = options ?? defaultOptions;
  const noMore = ref<boolean>(false);
  const isLoading = ref<boolean>(false);
  const isSuccess = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const data = ref<any>([]);
  let _successCount = 0;
  let _unitId: number;
  let _lastId = 0;
  const fetch = (unit_id: number) => {
    if (isLoading.value) return;
    _unitId = unit_id;
    isLoading.value = true;
    isSuccess.value = false;
    isFailed.value = false;
    fetcher(_lastId, limit, unit_id)
      .then((res) => {
        if (res.data.code > window.$code.OK) {
          isFailed.value = true;
          return;
        }
        isSuccess.value = true;
        _successCount += 1;
        if ((res.data.data as T[]).length < limit) noMore.value = true;
        data.value.push(...res.data.data!);
        _lastId = data.value[data.value.length - 1].id;
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        isLoading.value = false;
      });
  };
  const next = () => {
    if (!_successCount || noMore.value) return;
    fetch(_unitId);
  };
  const restore = () => {
    data.value = [];
    _lastId = 0;
    _successCount = 0;
    noMore.value = false;
    isLoading.value = false;
    isSuccess.value = false;
    isFailed.value = false;
  };
  const refetch = () => {
    fetch(_unitId);
  };

  return {
    isFailed,
    isLoading,
    isSuccess,
    noMore,
    data,
    fetch,
    next,
    restore,
    refetch,
  };
};
