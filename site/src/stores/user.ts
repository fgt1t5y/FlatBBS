import { getSessionUserInfo, logout } from '@/services';
import { acceptHMRUpdate, defineStore } from 'pinia';
import { computed, ref } from 'vue';
import { useMessage } from './message';

import type { User } from '@/types';

export const useUserStore = defineStore('user', () => {
  const info = ref<User>();
  const isLogin = ref<boolean>(false);

  const isAdmin = computed(() => {
    if (!info.value || !info.value.roles) {
      return false;
    }

    return info.value.roles.findIndex((r) => r.name === 'Administrator') !== -1;
  });

  const _verifyUser = (user: User) => {
    if (!user || !Array.isArray(user.roles) || !user.roles.length) {
      return false;
    }

    return true;
  };

  const _addListeners = () => {
    // refetch user info when userInfoChange event is triggered
    document.addEventListener('userInfoChange', fetch);
  };

  const fetch = async () => {
    const response = await getSessionUserInfo();

    if (response && _verifyUser(response)) {
      isLogin.value = true;
      info.value = response;
      _addListeners();
    } else {
      const ms = useMessage();
      // clearToken();
      ms.error('{{message.fetch_user_profile_fail}}');
    }
  };

  const quit = () => {
    logout().then(() => {
      location.reload();
    });
  };

  return { info, isLogin, isAdmin, fetch, quit };
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
