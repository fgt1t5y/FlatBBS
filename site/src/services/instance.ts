import axios, { type AxiosResponse } from 'axios';
import type { RequestResult } from './interface';
import { Message } from '@arco-design/web-vue';

export const requester = axios.create({
  baseURL: import.meta.env.VITE_FLAT_BASE,
  timeout: 5000,
  withCredentials: true,
});

requester.interceptors.request.use(
  (config) => {
    return config;
  },
  (error) => {
    Message.error('出现错误：请求未发出。');
    console.log(error);
    return Promise.reject(error);
  },
);

requester.interceptors.response.use(
  (res: AxiosResponse<RequestResult>) => {
    console.log(res);
    if (res.data.code > 0) {
      Message.error(res.data.message);
    }
    return res;
  },
  (error) => {
    Message.error('网络或服务器出现问题。');
    console.log(error);
    return Promise.reject(error);
  },
);
