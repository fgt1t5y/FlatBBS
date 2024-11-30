import Default from '@/layouts/Default.vue';
import HomeView from '@/views/HomeView.vue';
import BoardView from '@/views/BoardView.vue';
import type { RouteRecordRaw } from 'vue-router';

export const mainRoutes = [
  {
    path: '/',
    name: 'root',
    component: Default,
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
        path: 'publish',
        name: 'publish_page',
        component: () => import('@/views/PublishView.vue'),
        meta: {
          title: '发布',
        },
      },
      {
        path: 'board/:slug/publish',
        name: 'board_publish_page',
        component: () => import('@/views/BoardPublishView.vue'),
        meta: {
          title: '发布',
          memberOnly: true,
        },
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
          memberOnly: true,
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
        path: 'publish',
        name: 'publish_page',
        component: () => import('@/views/PublishView.vue'),
        meta: {
          title: '发布',
        },
      },
      {
        path: 'auth',
        name: 'auth_page',
        component: () => import('@/views/AuthView.vue'),
        meta: {
          title: '注册或登录',
          guestOnly: true,
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
] as RouteRecordRaw[];
