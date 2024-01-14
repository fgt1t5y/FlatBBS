import RootView from '@/views/RootView.vue';
import HomeView from '@/views/HomeView.vue';
import BoardView from '@/views/BoardView.vue';

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
          showBottomNav: true,
        },
      },
      {
        path: 'board/:slug',
        name: 'board_page',
        component: BoardView,
      },
      {
        path: 'board/:slug/publish',
        name: 'board_publish_page',
        component: () => import('@/views/BoardPublishView.vue'),
      },
      {
        path: 'topic/:topic_id(\\d+)',
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
          requireLogin: true,
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
        path: 'boards',
        name: 'board_list_page',
        component: () => import('@/views/BoardListView.vue'),
        meta: {
          title: '版块',
          showBottomNav: true,
        },
      },
      {
        path: 'people',
        name: 'user_space_page',
        component: () => import('@/views/UserSpaceView.vue'),
        meta: {
          title: '我的空间',
        },
      },
      {
        path: 'publish',
        name: 'publish_page',
        component: () => import('@/views/PublishView.vue'),
        meta: {
          title: '发布',
        },
      },
      {
        path: ':pathMatch(.*)*',
        name: 'not_found_page',
        component: () => import('@/views/NotFoundView.vue'),
        meta: {
          title: '404',
          showBottomNav: true,
        },
      },
    ],
  },
];
