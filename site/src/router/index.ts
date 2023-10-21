import { createRouter, createWebHistory } from 'vue-router';
import { mainRoutes } from './modules/main';
import { authRoutes } from './modules/auth';
import { settingsRoutes } from './modules/settings';
import { pureSetTitle } from '@/utils/useTitle';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...mainRoutes, ...authRoutes, ...settingsRoutes],
});

router.afterEach((to) => {
  if (to.meta.title) {
    pureSetTitle(to.meta.title as string);
  }
});

export default router;
