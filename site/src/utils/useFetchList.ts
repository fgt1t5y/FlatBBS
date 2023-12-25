import type { RequestResult } from '@/types';
import type { AxiosResponse } from 'axios';
import { isRef, ref, type MaybeRef } from 'vue';

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
  unit_id?: MaybeRef<number | string>,
  options?: FetchDataOptions,
) => {
  type hasID = T & { id: number };
  const { limit } = options ?? defaultOptions;
  const noMore = ref<boolean>(false);
  const isLoading = ref<boolean>(false);
  const isSuccess = ref<boolean>(false);
  const isFailed = ref<boolean>(false);
  const data = ref<hasID[]>([]);
  let _successCount = 0;
  let _lastId = 0;
  let _lastIndex = 0;
  const fetch = (clear: boolean = false) => {
    const id = isRef(unit_id) ? unit_id.value : unit_id;
    if (isLoading.value) return;
    isLoading.value = true;
    isSuccess.value = false;
    isFailed.value = false;
    clear && restore();
    fetcher(_lastId, limit, id)
      .then((res) => {
        const result = res.data as RequestResult<T[]>;
        if (result.code > window.$code.OK) {
          isFailed.value = true;
          return;
        }
        isSuccess.value = true;
        _successCount += 1;
        if (result.data!.length < limit) noMore.value = true;
        data.value.push(...res.data.data!);

        _lastId = data.value[data.value.length - 1].id;
        _lastIndex = data.value.length;
      })
      .catch(() => {
        isFailed.value = true;
      })
      .finally(() => {
        isLoading.value = false;
      });
  };
  const next = () => {
    if (noMore.value) return;
    fetch();
  };
  const restore = () => {
    data.value = [];
    _lastId = 0;
    _successCount = 0;
    noMore.value = false;
    isSuccess.value = false;
    isFailed.value = false;
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
  };
};
