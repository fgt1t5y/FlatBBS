import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import TopicList from "@/components/TopicList.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
      meta: {
        title: "首页",
      },
      children: [
        {
          path: "",
          component: TopicList,
        },
        {
          path: "brand",
          name: "brand",
          component: TopicList,
          meta: {
            title: "论坛版块",
          },
        },
      ],
    },
    {
      path: "/auth",
      name: "auth",
      component: () => import("../views/AuthView.vue"),
      meta: {
        title: "注册或登录",
      },
    },
  ],
});

router.afterEach((to) => {
  document.title = (to.meta.title as string) + " - Flat BBS";
});

export default router;
