import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
  type RouteRecordRaw,
} from 'vue-router';
import { mainRoutes } from './modules/main';
import { authRoutes } from './modules/auth';
import { pureSetTitle, hasToken } from '@/utils';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes, ...authRoutes] as RouteRecordRaw[],
});

router.beforeEach((to, from) => {
  if (hasToken()) {
    if (to.path === '/auth') {
      return { path: '/' };
    }
  } else {
    if (to.meta.requireLogin) {
      return { path: '/' };
    }
  }
});

router.afterEach((to, from, failure) => {
  if (isNavigationFailure(failure)) return;
  if (to.meta.title) {
    pureSetTitle(to.meta.title as string);
  }
});

export default router;
