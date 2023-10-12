export interface LoginForm {
  email: string;
  password: string;
}

export interface UploadForm {
  avgfile: File;
}

export interface RequestResult<T = any> {
  code: number;
  message: string;
  data?: T;
}
