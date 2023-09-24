import { getUserInfo } from "@/services/userinfo";
import { defineStore } from "pinia";

export const useUserInfo = defineStore("userinfo", {
  state: () => ({
    username: "",
    avatarUri: "",
  }),
  actions: {
    load() {
      console.log(getUserInfo());
    },
  },
});
