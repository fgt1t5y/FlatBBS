import axios from "axios";

export const requester = axios.create({
  baseURL: import.meta.env.VITE_FLAT_BASE,
  timeout: 2333,
  withCredentials: true,
});
