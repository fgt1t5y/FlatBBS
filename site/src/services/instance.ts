import axios from "axios";

export const requester = axios.create({
  baseURL: import.meta.env.VITE_FLAT_BASE,
  timeout: 2333,
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
  (res) => {
    console.log(res);
    return res.data;
  },
  (error) => {
    console.log(error);
    return Promise.reject(error);
  }
);
