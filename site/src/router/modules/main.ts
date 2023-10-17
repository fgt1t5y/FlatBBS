import MainView from '@/views/MainView.vue';
import TopicList from '@/components/TopicList.vue';

export const mainRoutes = [
  {
    path: '/',
    name: 'home',
    component: MainView,
    meta: {
      title: '首页',
    },
    children: [
      {
        path: '',
        name: 'all_topics',
        component: TopicList,
      },
      {
        path: 'board/:id',
        name: 'board_topics',
        component: TopicList,
        meta: {
          title: '论坛版块',
        },
      },
    ],
  },
];
