import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
  type RouteRecordRaw,
} from 'vue-router';
import { mainRoutes } from './modules/main';
import { pureSetTitle, hasToken } from '@/utils';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes] as RouteRecordRaw[],
});

router.beforeEach((to) => {
  if (hasToken()) {
    if (to.meta?.guestOnly) {
      return { name: 'root' };
    }
  } else {
    if (to.meta?.memberOnly) {
      if (window.$message) {
        window.$message.error('请先登录');
      }
      return { name: 'auth_page', query: { next: to.fullPath } };
    }
  }
});

router.afterEach((to, from, failure) => {
  if (isNavigationFailure(failure)) return;
  if (to.meta?.title) {
    pureSetTitle(to.meta.title as string);
  }
});

export default router;
