import { alovaInstance } from './instance';
import type { LoginForm, Result } from '@/types';
import { genForm } from '@/utils';

export const login = (email: string, password: string) => {
  const form = genForm<LoginForm>({
    email: email,
    password: password,
  });

  return alovaInstance.Post<Result<null>>('/auth/login', form);
};

export const logout = () => {
  return alovaInstance.Post<Result<null>>('/auth/logout');
};
