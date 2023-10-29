import axios, { type AxiosResponse } from 'axios';
import type { RequestResult } from '@/types';
import { Message } from '@arco-design/web-vue';

export const requester = axios.create({
  baseURL: '/backend',
  timeout: 5000,
  withCredentials: true,
});

const complainError = (content: string) => {
  Message.error(content);
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
    console.log(res);
    if (res.data.code > 0 && res.data.message !== '') {
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
