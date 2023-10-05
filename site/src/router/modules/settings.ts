export const settingsRoutes = [
  {
    path: "/settings",
    name: "settings",
    component: () => import("@/views/SettingsView.vue"),
    meta: {
      title: "设置",
    },
  },
];
