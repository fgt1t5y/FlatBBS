import { requester } from "./instance";

export const login = async (email: string, password: string) => {
  requester
    .post(
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
