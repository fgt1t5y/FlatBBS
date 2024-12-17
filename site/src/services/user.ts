import { genForm } from '@/utils';
import { alovaInstance } from './instance';
import type { UploadForm, User } from '@/types';

export const getSessionUserInfo = () => {
  return alovaInstance.Get<User>('/user/info');
};

export const getUserDetail = (user_id: number) => {
  return alovaInstance.Get<User>('/user/detail', {
    params: {
      user_id,
    },
  });
};

export const getUserDetailByUsername = (username: string) => {
  return alovaInstance.Get<User>('/user/detail', {
    params: {
      username,
    },
  });
};

export const modifyUserInfo = (field: string, value: string) => {
  return alovaInstance.Post<null>('/user/modify', { field, value });
};

export const modifyUserAvatar = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return alovaInstance.Post<string[]>('/user/avatar', form);
};

export const modifyPassword = (old_password: string, new_password: string) => {
  return alovaInstance.Post<string[]>('/user/password', {
    old_password,
    new_password,
  });
};
