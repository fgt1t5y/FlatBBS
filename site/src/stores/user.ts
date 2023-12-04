import { getUserInfo, logout } from '@/services';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { UserInfo } from '@/types';

export const useUserStore = defineStore('user', () => {
  const info = ref<UserInfo>();
  const isLogin = ref<boolean>(false);
  const fetch = async () => {
    getUserInfo().then((res) => {
      if (res.data.code > window.$code.OK) return;
      isLogin.value = true;
      info.value = res.data.data;
    });
  };
  const quit = () => {
    logout().then(() => {
      location.reload();
    });
  };

  return { info, isLogin, fetch, quit };
});
