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

export interface RequestResult<T = any> {
  code: number;
  message: string;
  data?: T;
}
