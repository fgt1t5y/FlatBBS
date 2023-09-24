import axios, { type AxiosResponse } from "axios";
import type { RequestResult } from "./interface";
import { Message } from "@arco-design/web-vue";

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
    console.log(error);
    return Promise.reject(error);
  }
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
    console.log(error);
    return Promise.reject(error);
  }
);
