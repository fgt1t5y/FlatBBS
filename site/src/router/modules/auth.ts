import type { RouteRecordRaw } from 'vue-router';

export const authRoutes: RouteRecordRaw[] = [
  {
    path: '/auth',
    name: 'login_register_page',
    component: () => import('@/views/AuthView.vue'),
    meta: {
      title: '注册或登录',
    },
  },
];
