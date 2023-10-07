import { getUserInfo } from '@/services/userinfo';
import { defineStore } from 'pinia';
import { computed, reactive, ref } from 'vue';
import Cookies from 'js-cookie';

interface UserInfo {
  avatar_uri?: string;
  username?: string;
  uid?: number;
  email?: string;
}

export const useUserStore = defineStore('user', () => {
  const info = reactive<UserInfo>({
    avatar_uri: undefined,
    username: undefined,
    email: undefined,
    uid: undefined,
  });

  const isLogin = ref<boolean>(false);

  const hasToken = computed(() => {
    return !!Cookies.get('flat_sess');
  });

  const loadUserInfo = () => {
    getUserInfo().then((res) => {
      if (res.data.code === 0) {
        isLogin.value = true;
        const avatar_prefix = import.meta.env.VITE_USER_AVATAR_PATH;
        const { avatar_uri, username, uid, email } = res.data.data as UserInfo;
        info.avatar_uri =
          'http://localhost:3900/public/usercontent/' + avatar_uri;
        info.username = username;
        info.uid = uid;
        info.email = email;
      }
    });
  };

  return { info, isLogin, loadUserInfo, hasToken };
});
