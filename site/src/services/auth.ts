import { alovaInstance } from './instance';
import type { Result, LoginForm } from '@/types';
import { genForm } from '@/utils';

export const login = (email: string, password: string) => {
  const form = genForm<LoginForm>({
    email: email,
    password: password,
  });

  return alovaInstance.Post<Result>('/auth/login', form);
};

export const logout = () => {
  return alovaInstance.Post<Result>('/auth/logout');
};
