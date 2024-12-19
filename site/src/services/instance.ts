import { config } from '@/global';
import { useMessage } from '@/stores';
import type { Result } from '@/types';
import { createAlova } from 'alova';
import adapterFetch from 'alova/fetch';
import VueHook from 'alova/vue';

export const alovaInstance = createAlova({
  baseURL: config.api_base,
  requestAdapter: adapterFetch(),
  statesHook: VueHook,
  timeout: 10000,
  responded: {
    onSuccess: async (res) => {
      if (res.status === window.$code.INTERNAL_ERROR) {
        throw new Error('Server Internal Error');
      }

      const json = (await res.json()) as Result;

      if (!json.code) {
        throw new Error('Invalid Response Body');
      }

      if (json.code !== window.$code.OK) {
        const ms = useMessage();
        ms.error(json.message || 'Network Error');
        throw new Error(json.message || 'Network Error');
      }

      return json.data;
    },
    onError: () => {
      const ms = useMessage();
      ms.error('Network Error');
    },
  },
});
