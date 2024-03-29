import { createAlova } from 'alova';
import GlobalFetch from 'alova/GlobalFetch';
import VueHook from 'alova/vue';

export const alovaInstance = createAlova({
  baseURL: '/backend',
  requestAdapter: GlobalFetch(),
  statesHook: VueHook,
  timeout: 10000,
  responded: {
    onSuccess: (res) => res.json(),
    onError: () => {
      window.$message.error('网络错误');
    },
  },
});
