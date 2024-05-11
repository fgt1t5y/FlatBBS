import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
  type RouteRecordRaw,
} from 'vue-router';
import { mainRoutes } from './modules/main';
import { authRoutes } from './modules/auth';
import { pureSetTitle, hasToken } from '@/utils';

const rootRoute = '/';
const authRoute = '/auth';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes, ...authRoutes] as RouteRecordRaw[],
});

router.beforeEach((to) => {
  if (hasToken()) {
    if (to.meta?.guestOnly) {
      return { path: rootRoute };
    }
  } else {
    if (to.meta?.memberOnly) {
      return { path: authRoute, query: { next: to.fullPath } };
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
