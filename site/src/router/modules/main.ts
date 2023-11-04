import RootView from '@/views/RootView.vue';
import HomeView from '@/views/HomeView.vue';

export const mainRoutes = [
  {
    path: '/',
    name: 'root',
    component: RootView,
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
        meta: {
          title: '首页',
        },
      },
      {
        path: 'board/:id',
        name: 'board',
        component: HomeView,
        meta: {
          title: '版块',
        },
      },
      {
        path: 'settings',
        name: 'settings',
        component: () => import('@/views/SettingsView.vue'),
        meta: {
          title: '设置',
        },
      },
      {
        path: 'search',
        name: 'search',
        component: () => import('@/views/SearchView.vue'),
        meta: {
          title: '搜索',
        },
      },
    ],
  },
];
