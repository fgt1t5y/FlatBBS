import { getUserInfo, logout } from '@/services';
import { defineStore } from 'pinia';
import { ref, shallowRef } from 'vue';
import type { User } from '@/types';

export const useUserStore = defineStore('user', () => {
  const info = shallowRef<User>();
  const isLogin = ref<boolean>(false);
  const fetch = async () => {
    getUserInfo()
      .then((res) => {
        isLogin.value = true;
        info.value = res.data;
      })
      .catch(() => {
        window.$message.error('获取用户信息失败');
      });
  };
  const quit = () => {
    logout().then(() => {
      location.reload();
    });
  };

  return { info, isLogin, fetch, quit };
});
