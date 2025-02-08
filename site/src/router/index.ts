import {
  createRouter,
  createWebHistory,
  isNavigationFailure,
  type RouteRecordRaw,
} from 'vue-router';
import { siteRoute } from './modules/site';
import { adminRoute } from './modules/admin';
import { useUserStore } from '@/stores';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    siteRoute,
    adminRoute,
    {
      path: '/:pathMatch(.*)*',
      name: 'not_found',
      component: () => import('@/views/NotFoundView.vue'),
      meta: {
        showBottomNav: true,
      },
    },
  ] as RouteRecordRaw[],
});

router.beforeEach((to) => {
  const user = useUserStore();

  if (user.isLogin) {
    if (to.meta?.guestOnly || (to.meta?.adminOnly && !user.isAdmin)) {
      return { name: 'home' };
    }
  } else {
    if (to.meta?.userOnly || to.meta?.adminOnly) {
      return { name: 'auth', query: { next: to.fullPath } };
    }
  }
});

router.afterEach((to, from, failure) => {
  if (isNavigationFailure(failure)) {
    return;
  }
});

export default router;
