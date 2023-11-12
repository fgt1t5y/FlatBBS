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
        name: 'home_page',
        component: HomeView,
        meta: {
          title: '首页',
        },
      },
      {
        path: 'board/:id',
        name: 'board_page',
        component: HomeView,
        meta: {
          title: '版块',
        },
      },
      {
        path: 'topic/:id',
        name: 'topic_detail_page',
        component: () => import('@/views/TopicView.vue'),
        meta: {
          title: '话题',
        },
      },
      {
        path: 'settings',
        name: 'settings_page',
        component: () => import('@/views/SettingsView.vue'),
        meta: {
          title: '设置',
        },
      },
      {
        path: 'search',
        name: 'search_page',
        component: () => import('@/views/SearchView.vue'),
        meta: {
          title: '搜索',
        },
      },
      {
        path: ':pathMatch(.*)*',
        name: 'not_found_page',
        component: () => import('@/views/NotFoundView.vue'),
        meta: {
          title: '404',
        },
      },
    ],
  },
];
