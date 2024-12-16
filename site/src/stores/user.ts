import { getSessionUserInfo, logout } from '@/services';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { User } from '@/types';
import { useMessage } from './message';

export const useUserStore = defineStore('user', () => {
  const info = ref<User>();
  const isLogin = ref<boolean>(false);
  const fetch = async () => {
    getSessionUserInfo()
      .then((res) => {
        isLogin.value = true;
        info.value = res;
      })
      .catch(() => {
        const ms = useMessage();
        // TODO: i18n
        ms.error('获取用户信息失败');
      });
  };
  const quit = () => {
    logout().then(() => {
      location.reload();
    });
  };

  return { info, isLogin, fetch, quit };
});
