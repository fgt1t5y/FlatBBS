import { alovaInstance } from './instance';
import { genForm } from '@/utils';

import type { LoginForm, Result } from '@/types';

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
