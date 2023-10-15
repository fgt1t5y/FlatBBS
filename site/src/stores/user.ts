import { getUserInfo } from '@/services/userinfo';
import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import type { UserInfo } from '@/types';

export const useUserStore = defineStore('user', () => {
  const info = reactive<UserInfo>({
    avatar_uri: undefined,
    username: undefined,
    email: undefined,
    id: undefined,
    introduction: undefined,
  });

  const isLogin = ref<boolean>(false);

  /**
   * 从后端获取用户和网站的配置
   */
  const fetch = () => {
    getUserInfo().then((res) => {
      if (res.data.code === 0) {
        isLogin.value = true;
        const { avatar_uri, username, id, email, introduction } = res.data
          .data as UserInfo;
        info.avatar_uri = `/backend/public/usercontent/${avatar_uri}`;
        info.username = username;
        info.id = id;
        info.email = email;
        info.introduction = introduction;
      }
    });
  };

  const clear = () => {
    return;
  };

  return { info, isLogin, fetch, clear };
});
