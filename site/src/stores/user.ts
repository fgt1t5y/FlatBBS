import { getSessionUserInfo, logout } from '@/services';
import { acceptHMRUpdate, defineStore } from 'pinia';
import { computed, ref } from 'vue';
import { useMessage } from './message';
import { UserRole } from '@/constants';

import type { User } from '@/types';

export const useUserStore = defineStore('user', () => {
  const info = ref<User>();
  const isLogin = ref<boolean>(false);

  const isAdmin = computed(() => {
    if (!info.value || !info.value.roles) {
      return false;
    }

    return info.value.roles.findIndex((r) => r.id === UserRole.ADMIN) !== -1;
  });

  const fetch = async () => {
    const user = await getSessionUserInfo();

    if (user && Array.isArray(user.roles) && user.roles.length) {
      isLogin.value = true;
      info.value = user;
    } else {
      const ms = useMessage();
      ms.error('$message.fetch_user_profile_fail');
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
