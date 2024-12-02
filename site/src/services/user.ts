import { genForm } from '@/utils';
import { alovaInstance } from './instance';
import type { UploadForm, User } from '@/types';

export const getUserInfo = () => {
  return alovaInstance.Post<User>('/user/info');
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
