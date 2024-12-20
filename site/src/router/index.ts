import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
  type RouteRecordRaw,
} from 'vue-router';
import { mainRoutes } from './modules/main';
import { hasToken } from '@/utils';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes] as RouteRecordRaw[],
});

router.beforeEach((to) => {
  if (hasToken()) {
    if (to.meta?.guestOnly) {
      return { name: 'home' };
    }
  } else {
    if (to.meta?.memberOnly) {
      return { name: 'auth_page', query: { next: to.fullPath } };
    }
  }
});

router.afterEach((to, from, failure) => {
  if (isNavigationFailure(failure)) return;
});

export default router;
