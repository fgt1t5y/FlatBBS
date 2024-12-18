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
        ms.error('i18n$message.fetch_user_profile_fail');
      });
  };
  const quit = () => {
    logout().then(() => {
      location.reload();
    });
  };

  return { info, isLogin, fetch, quit };
});
