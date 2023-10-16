import HomeView from '@/views/HomeView.vue';
import TopicList from '@/components/TopicList.vue';

export const homeRoutes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      title: '首页',
    },
    children: [
      {
        path: '',
        name: 'topics',
        component: TopicList,
      },
      {
        path: 'board/:id',
        name: 'board',
        component: TopicList,
        meta: {
          title: '论坛版块',
        },
      },
    ],
  },
];
