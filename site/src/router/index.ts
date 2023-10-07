import { createRouter, createWebHistory } from 'vue-router';
import { homeRoutes } from './modules/home';
import { authRoutes } from './modules/auth';
import { settingsRoutes } from './modules/settings';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...homeRoutes, ...authRoutes, ...settingsRoutes],
});

router.afterEach((to) => {
  document.title = (to.meta.title as string) + ' - Flat BBS';
});

export default router;
