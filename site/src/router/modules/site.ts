import HomeView from '@/views/HomeView.vue';
import BoardView from '@/views/BoardView.vue';
import SiteLayout from '@/layouts/SiteLayout.vue';

import type { RouteRecordRaw } from 'vue-router';

export const siteRoute = {
  path: '/',
  name: 'root',
  component: SiteLayout,
  children: [
    {
      path: '',
      name: 'home',
      component: HomeView,
      meta: {
        showBottomNav: true,
      },
    },
    {
      path: 'board/:boardSlug',
      name: 'board',
      component: BoardView,
    },
    {
      path: 'board/:boardSlug/publish',
      name: 'board_publish',
      component: () => import('@/views/BoardPublishView.vue'),
      meta: {
        userOnly: true,
      },
    },
    {
      path: 'topic/:topicId(\\d+)',
      name: 'topic',
      component: () => import('@/views/TopicView.vue'),
    },
    {
      path: 'topic/:topicId(\\d+)/edit',
      name: 'topic_edit',
      component: () => import('@/views/EditTopicView.vue'),
    },
    {
      path: 'settings',
      name: 'settings',
      component: () => import('@/views/SettingsView.vue'),
      meta: {
        userOnly: true,
      },
    },
    {
      path: 'settings/password',
      name: 'modify_password',
      component: () => import('@/views/ModifyPasswordView.vue'),
      meta: {
        userOnly: true,
      },
    },
    {
      path: 'settings/avatar',
      name: 'modify_avatar',
      component: () => import('@/views/ModifyAvatarView.vue'),
      meta: {
        userOnly: true,
      },
    },
    {
      path: 'user/:username',
      name: 'user',
      redirect(to) {
        return {
          name: 'user_topics',
          params: { username: to.params.username },
        };
      },
      component: () => import('@/views/UserView.vue'),
      children: [
        {
          path: '',
          name: 'user_topics',
          component: () => import('@/views/user/TopicsView.vue'),
        },
        {
          path: 'liked',
          name: 'user_liked_topics',
          component: () => import('@/views/user/LikedTopicsView.vue'),
        },
      ],
    },
    {
      path: 'search',
      name: 'search',
      component: () => import('@/views/SearchView.vue'),
    },
    {
      path: 'boards',
      name: 'board_list',
      component: () => import('@/views/BoardListView.vue'),
      meta: {
        showBottomNav: true,
      },
    },
    {
      path: 'auth',
      name: 'auth',
      component: () => import('@/views/AuthView.vue'),
      meta: {
        guestOnly: true,
      },
    },
    {
      path: 'logs',
      name: 'logs',
      component: () => import('@/views/UserVisitLogView.vue'),
      meta: {
        userOnly: true,
      },
    },
  ],
} as RouteRecordRaw;
