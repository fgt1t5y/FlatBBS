import { requester } from "./instance";
import type { RequestResult } from "./interface";

export const getUserInfo = () => {
  return requester.post<RequestResult>("auth/userinfo");
};