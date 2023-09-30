export const authRoutes = [
  {
    path: "/auth",
    name: "auth",
    component: () => import("@/views/AuthView.vue"),
    meta: {
      title: "注册或登录",
    },
  },
]
