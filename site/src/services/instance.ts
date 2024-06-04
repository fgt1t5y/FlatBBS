import { config } from '@/global';
import type { Result } from '@/types';
import { clearToken } from '@/utils';
import { createAlova } from 'alova';
import GlobalFetch from 'alova/GlobalFetch';
import VueHook from 'alova/vue';

export const alovaInstance = createAlova({
  baseURL: config.api_base,
  requestAdapter: GlobalFetch(),
  statesHook: VueHook,
  timeout: 10000,
  responded: {
    onSuccess: async (res) => {
      if (res.status > window.$code.OK) {
        throw new Error('服务器错误');
      }
      const json = (await res.json()) as Result;
      const code = json.code;

      if (code && code !== window.$code.OK) {
        // 服务器回报未认证，直接清空本地状态Cookie
        if (code === window.$code.UNAUTHORIZED) clearToken();
        throw new Error(json.message || '网络错误');
      }

      return json;
    },
    onError: () => {
      window.$message.error('网络错误');
    },
  },
});
