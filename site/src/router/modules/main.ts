import HomeView from '@/views/HomeView.vue';
import BoardView from '@/views/BoardView.vue';
import type { RouteRecordRaw } from 'vue-router';

export const mainRoutes = [
  {
    path: '/',
    name: 'home_page',
    component: HomeView,
    meta: {
      showBottomNav: true,
    },
  },
  {
    path: '/board/:slug',
    name: 'board_page',
    component: BoardView,
  },
  {
    path: '/board/:slug/publish',
    name: 'board_publish_page',
    component: () => import('@/views/BoardPublishView.vue'),
    meta: {
      memberOnly: true,
    },
  },
  {
    path: '/topic/:topic_id(\\d+)',
    name: 'topic_detail_page',
    component: () => import('@/views/TopicView.vue'),
  },
  {
    path: '/settings',
    name: 'settings_page',
    component: () => import('@/views/SettingsView.vue'),
    meta: {
      memberOnly: true,
    },
  },
  {
    path: '/user/:username',
    name: 'user_page',
    component: () => import('@/views/UserView.vue'),
  },
  {
    path: '/setting/password',
    name: 'modify_password',
    component: () => import('@/views/ModifyPasswordView.vue'),
    meta: {
      memberOnly: true,
    },
  },
  {
    path: '/search',
    name: 'search_page',
    component: () => import('@/views/SearchView.vue'),
  },
  {
    path: '/boards',
    name: 'board_list_page',
    component: () => import('@/views/BoardListView.vue'),
    meta: {
      showBottomNav: true,
    },
  },
  {
    path: '/auth',
    name: 'auth_page',
    component: () => import('@/views/AuthView.vue'),
    meta: {
      guestOnly: true,
    },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not_found_page',
    component: () => import('@/views/NotFoundView.vue'),
    meta: {
      showBottomNav: true,
    },
  },
] as RouteRecordRaw[];
