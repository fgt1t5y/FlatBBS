import { genForm } from '@/utils';
import { alovaInstance } from './instance';

import type { UploadForm, User } from '@/types';

export const getSessionUserInfo = () => {
  return alovaInstance.Get<User>('/me/info');
};

export const modifyUserInfo = (field: string, value: string) => {
  return alovaInstance.Post<null>('/me/info', { [field]: value });
};

export const modifyUserAvatar = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return alovaInstance.Post<string[]>('/me/avatar', form);
};

export const modifyPassword = (old_password: string, new_password: string) => {
  return alovaInstance.Post<string[]>('/me/password', {
    old_password,
    new_password,
  });
};
