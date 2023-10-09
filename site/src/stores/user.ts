import { getUserInfo } from '@/services/userinfo';
import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';

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

  const isLogin = ref<boolean>(false);

  const login = () => {
    getUserInfo().then((res) => {
      if (res.data.code === 0) {
        isLogin.value = true;
        const { avatar_uri, username, id, email } = res.data.data as UserInfo;
        info.avatar_uri =
          'http://localhost:3900/public/usercontent/' + avatar_uri;
        info.username = username;
        info.id = id;
        info.email = email;
        console.warn(info);
      }
    });
  };

  return { info, isLogin, login };
});
