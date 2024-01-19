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
    return res;
  },
  (error) => {
    const status = error.response.status;
    if (status === window.$code.UNAUTHORIZED) {
      router.replace({
        path: '/auth',
        query: { next: router.currentRoute.value.path },
      });
    }
    if (status === window.$code.NOT_FOUND) {
      router.replace({
        name: 'not_found_page',
      });
    }
    complainError(error.response.data.message);

    console.log(error);
    return Promise.reject(error);
  },
);
