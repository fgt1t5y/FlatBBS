import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
} from 'vue-router';
import { mainRoutes } from './modules/main';
import { authRoutes } from './modules/auth';
import { pureSetTitle } from '@/utils/useTitle';
import { hasToken } from '@/utils';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes, ...authRoutes],
});

router.beforeEach((to) => {
  if (to.path === '/auth' && hasToken()) {
    return { path: '/' };
  }
});

router.afterEach((to, from, failure) => {
  if (isNavigationFailure(failure)) return;
  if (to.meta.title) {
    pureSetTitle(to.meta.title as string);
  }
});

export default router;
