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
  avgfile: File;
  as?: UploadAs;
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
}

export interface BoardGroups {
  id: number;
  name: string;
  board: Board[];
}

export type ThemeMode = 'auto' | 'light' | 'dark';
