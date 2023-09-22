import { requester } from "./instance";
import type { LoginInfo, RequestResult } from "./interface";

export const login = async (email: string, password: string) => {
  requester
    .post<any, RequestResult, LoginInfo>(
      "/auth/login",
      {
        email: email,
        password: password,
      },
      {
        withCredentials: true,
      }
    )
    .then((res) => {
      console.log(res);
    });
};
