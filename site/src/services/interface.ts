export interface LoginForm {
  email: string;
  password: string;
}

export interface RequestResult<T = any> {
  code: number;
  message: string;
  data?: T;
  token?: string;
}
