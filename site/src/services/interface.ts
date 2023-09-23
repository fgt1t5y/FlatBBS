export interface LoginForm {
  email: string;
  password: string;
}

export interface RequestResult {
  code: number;
  message: string;
  data?: any;
  token?: string;
}
