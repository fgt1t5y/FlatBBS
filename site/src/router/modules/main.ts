import HomeView from '@/views/HomeView.vue';
import BoardView from '@/views/BoardView.vue';
import type { RouteRecordRaw } from 'vue-router';

export const mainRoutes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      showBottomNav: true,
    },
  },
  {
    path: '/board/:slug',
    name: 'board',
    component: BoardView,
  },
  {
    path: '/board/:slug/publish',
    name: 'board_publish',
    component: () => import('@/views/BoardPublishView.vue'),
    meta: {
      userOnly: true,
    },
  },
  {
    path: '/topic/:topic_id(\\d+)',
    name: 'topic',
    component: () => import('@/views/TopicView.vue'),
  },
  {
    path: '/settings',
    name: 'settings',
    component: () => import('@/views/SettingsView.vue'),
    meta: {
      userOnly: true,
    },
  },
  {
    path: '/user/:username',
    component: () => import('@/views/UserView.vue'),
    children: [
      {
        path: '',
        name: 'user',
        component: () => import('@/views/user/TopicsView.vue'),
      },
      {
        path: 'liked',
        name: 'user_liked_topics',
        component: () => import('@/views/user/LikedTopicsView.vue'),
      }
    ],
  },
  {
    path: '/setting/password',
    name: 'modify_password',
    component: () => import('@/views/ModifyPasswordView.vue'),
    meta: {
      userOnly: true,
    },
  },
  {
    path: '/search',
    name: 'search',
    component: () => import('@/views/SearchView.vue'),
  },
  {
    path: '/boards',
    name: 'board_list',
    component: () => import('@/views/BoardListView.vue'),
    meta: {
      showBottomNav: true,
    },
  },
  {
    path: '/auth',
    name: 'auth',
    component: () => import('@/views/AuthView.vue'),
    meta: {
      guestOnly: true,
    },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not_found',
    component: () => import('@/views/NotFoundView.vue'),
    meta: {
      showBottomNav: true,
    },
  },
] as RouteRecordRaw[];
