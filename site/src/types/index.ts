export interface Result {
  code: number;
  message?: string;
}

export interface User {
  id?: number;
  display_name?: string;
  username?: string;
  email?: string;
  avatar_uri?: string;
  introduction?: string;
}

export interface UserInfo extends Result {
  data: User;
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

export interface UploadResult extends Result {
  data: string[];
}

export interface Board {
  id: number;
  name: string;
  slug: string;
  description?: string;
  avatar_uri: string;
  header_img_uri: string;
  color: string;
}

export interface Boards extends Result {
  data: Board[];
}

export type Author = Pick<User, 'id' | 'display_name' | 'avatar_uri'>;

export interface Topic {
  id: number;
  title: string;
  content?: string;
  author: Author;
  board: Board;
  board_id: number;
  author_id: number;
  reply_count: number;
  created_at: string;
  last_reply_at: string;
}

export interface Topics extends Result {
  data: Topic[];
}

export type TopicDraft = Pick<Topic, 'title' | 'content' | 'board_id'>;

export interface Discussion {
  id: number;
  content: string;
  created_at: string;
  author: Author;
  like_count: number;
}

export interface Discussions extends Result {
  data: Discussion[];
}

export type ThemeMode = 'auto' | 'light' | 'dark';
