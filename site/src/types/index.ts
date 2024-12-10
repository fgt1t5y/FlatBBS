export interface Result<T = null> {
  code: number;
  message?: string;
  data: T;
}

export interface User {
  id?: number;
  display_name?: string;
  username?: string;
  email?: string;
  avatar_uri?: string;
  introduction?: string;
  roles: Role[];
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
  color: string;
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
  reply_count: number;
  created_at: string;
  last_reply_at: string;
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

export interface IMessage {
  i: number;
  message: string;
  type?: 'info' | 'success' | 'error';
  time?: number;
}
