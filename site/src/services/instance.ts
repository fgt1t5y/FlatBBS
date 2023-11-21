import axios, { type AxiosResponse } from 'axios';
import type { RequestResult } from '@/types';
import { config } from '@/global';
import router from '@/router';

export const requester = axios.create({
  baseURL: config.api_base,
  timeout: 5000,
  withCredentials: true,
});

const complainError = (content: string) => {
  if (content === '') return;

  window.$message.error(content);
};

requester.interceptors.request.use(
  (config) => {
    return config;
  },
  (error) => {
    complainError('出现错误：请求未发出。');
    console.log(error);
    return Promise.reject(error);
  },
);

requester.interceptors.response.use(
  (res: AxiosResponse<RequestResult>) => {
    if (typeof res.data.code !== 'number') {
      complainError('服务器内部错误');
    }
    if (res.data.code > window.$code.OK) {
      if (res.data.code === window.$code.UNAUTHORIZED) {
        router.replace({
          path: '/auth',
          query: { next: router.currentRoute.value.path },
        });
      }
      if (res.data.code === window.$code.NOT_FOUND) {
        console.log(1);
        router.replace({
          name: 'not_found_page',
        });
      }
      complainError(res.data.message);
    }
    return res;
  },
  (error) => {
    complainError('网络或服务器出现问题。');
    console.log(error);
    return Promise.reject(error);
  },
);
