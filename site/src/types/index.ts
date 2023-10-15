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

export interface RequestResult {
  code: number;
  message: string;
  data?: {
    uri: string
  };
}

export type ThemeMode = 'auto' | 'light' | 'dark';
