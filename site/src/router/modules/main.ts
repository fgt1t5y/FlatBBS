import MainView from '@/views/MainView.vue';
import TopicList from '@/components/TopicList.vue';

export const mainRoutes = [
  {
    path: '/',
    name: 'root',
    component: MainView,
    children: [
      {
        path: '',
        name: 'home',
        component: TopicList,
        meta: {
          title: '首页',
        },
      },
      {
        path: 'board/:id',
        name: 'board',
        component: TopicList,
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
    ],
  },
];
