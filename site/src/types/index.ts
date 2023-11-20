export interface UserInfo {
  avatar_uri?: string;
  username?: string;
  id?: number;
  email?: string;
  introduction?: string;
}

export interface LoginForm {
  email: string;
  password: string;
}

export interface UserModifyForm {
  field: string;
  value: string;
}

/**
 * 上传的文件的用途：
 * 'avatar' - 用作用户的新头像，
 * 'attachment' - 用作话题内容的图片附件
 */
export type UploadAs = 'avatar' | 'attachment';

export interface UploadForm {
  avgfile: File[];
  as?: UploadAs;
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

export interface UploadResult {
  uri: string;
}

export interface RequestResult<T = any> {
  code: number;
  message: string;
  data?: T;
}

export interface Board {
  id: number;
  name: string;
  color: string;
}

export type Author = Pick<UserInfo, 'id' | 'username' | 'avatar_uri'>;

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

export type TopicDraft = Pick<Topic, 'title' | 'content' | 'board_id'>;

export interface Discussion {
  id: number;
  content: string;
  created_at: string;
  author: Author;
  like_count: number;
}

export type ThemeMode = 'auto' | 'light' | 'dark';
