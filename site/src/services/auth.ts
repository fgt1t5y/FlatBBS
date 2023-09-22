import { requester } from "./instance";
import type { RequestResult, LoginForm } from "./interface";
import { genForm } from "./utils";

export const login = async (email: string, password: string) => {
  const form = genForm<LoginForm>({
    email: email,
    password: password,
  });

  requester
    .post<RequestResult>("/auth/login", form, {
      withCredentials: true,
    })
    .then((res) => {
      return res.data;
    });
};
