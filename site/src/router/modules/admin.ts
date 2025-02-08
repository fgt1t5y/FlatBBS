import type { RouteRecordRaw } from 'vue-router';

export const adminRoute = {
  path: '/_admin',
  name: 'admin',
  component: () => import('@/layouts/AdminLayout.vue'),
  meta: {
    adminOnly: true
  },
  children: [
    {
      path: '',
      name: 'admin_home',
      component: () => import('@/views/admin/HomeView.vue'),
    },
  ],
} as RouteRecordRaw;
