import { getUserInfo } from '@/services/userinfo';
import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';

interface UserInfo {
  avatar_uri?: string;
  username?: string;
  id?: number;
  email?: string;
}

export const useUserStore = defineStore('user', () => {
  const info = reactive<UserInfo>({
    avatar_uri: undefined,
    username: undefined,
    email: undefined,
    id: undefined,
  });
  const emptyInfo = info;

  const isLogin = ref<boolean>(false);

  /**
   * 从后端获取用户和网站的配置
   */
  const fetch = () => {
    getUserInfo().then((res) => {
      if (res.data.code === 0) {
        isLogin.value = true;
        const { avatar_uri, username, id, email } = res.data.data as UserInfo;
        info.avatar_uri = `/backend/public/usercontent/${avatar_uri}`;
        info.username = username;
        info.id = id;
        info.email = email;
      }
    });
  };

  const clear = () => {
    return;
  };

  return { info, isLogin, fetch, clear };
});
