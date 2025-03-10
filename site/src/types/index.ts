import type { Component, Ref } from 'vue';
import type { Rules, ValidateErrorMap } from '@/third-party/async-validator';

export interface Result<T = null> {
  code: number;
  message?: string;
  data: T;
}

export interface User {
  id: number;
  display_name: string;
  username: string;
  email?: string;
  avatar_uri: string;
  introduction: string;
  roles: Role[];
  created_at?: string;
  allow_login?: number;
}

export interface Role {
  id: number;
  name: string;
  description?: string;
}

export interface LoginForm {
  email: string;
  password: string;
}

export interface UserModifyForm {
  field: string;
  value: string;
}

export interface UploadForm {
  avgfile: File | File[];
}

export interface CommonListForm {
  last: number;
  limit: number;
  id?: number;
}

export interface TopicListForm {
  last: number;
  limit: number;
  board: number;
}

export interface CreateTopicForm {
  title: string;
  content: string;
  board: number;
}

export interface Board {
  id: number;
  name: string;
  slug: string;
  description?: string;
  avatar_uri: string;
  topic_count: number;
}

export interface Topic {
  id: number;
  title: string;
  text: string;
  content: string;
  author: User;
  board: Board;
  board_id: number;
  author_id: number;
  discussion_count: number;
  like_count: number;
  created_at: string;
  last_reply_at: string;
  likes: User[];
}

export type TopicDraft = Pick<Topic, 'title' | 'content' | 'board_id'>;

export interface Discussion {
  id: number;
  content: string;
  created_at: string;
  author: User;
  like_count: number;
}

export type ThemeMode = 'auto' | 'light' | 'dark';

export interface Message {
  i: number;
  message: string;
  type?: 'info' | 'success' | 'error';
  time?: number;
}

export interface RouteTab {
  routeName: string;
  label: string;
  params: any;
}

export type RouteMenuItem = RouteTab;

export interface IFormContext {
  rules: Ref<Rules>;
  disabled: boolean;
  errorMessages: Ref<ValidateErrorMap>;
  onFormItemBlur: (ev: FocusEvent) => void;
}

export interface UserVisitLog<T = unknown> {
  id: number;
  user_id: number;
  visitable_id: number;
  visitable_type: string;
  updated_at: string;
  created_at: string;
  visitable: T;
}

export type StringComponentMap = {
  [string: string]: Component
}
