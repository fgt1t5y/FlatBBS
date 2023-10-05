import { createRouter, createWebHistory } from "vue-router";
import { homeRoutes } from "./modules/home";
import { authRoutes } from "./modules/auth";
import { topicRoutes } from "./modules/topic";
import { settingsRoutes } from "./modules/settings";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [...homeRoutes, ...authRoutes, ...topicRoutes, ...settingsRoutes],
});

router.afterEach((to) => {
  document.title = (to.meta.title as string) + " - Flat BBS";
});

export default router;
