import { alovaInstance } from './instance';
import { genForm } from '@/utils';

import type { LoginForm, Result, User } from '@/types';

export const getSessionUserInfo = () => {
  return alovaInstance.Get<User>('/auth/info');
};

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
