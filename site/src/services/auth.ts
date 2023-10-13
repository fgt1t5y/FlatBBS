import { requester } from './instance';
import type { RequestResult, LoginForm } from './interface';
import { genForm } from '@/utils';

export const login = (email: string, password: string) => {
  const form = genForm<LoginForm>({
    email: email,
    password: password,
  });

  return requester.post<RequestResult>('/auth/login', form);
};

export const logout = () => {
  return requester.post<RequestResult>('/auth/logout');
};
