import { genForm } from '@/utils';
import { alovaInstance } from './instance';
import type { Result, UserInfo, UploadForm, UploadResult } from '@/types';

export const getUserInfo = () => {
  return alovaInstance.Post<UserInfo>('/user/info');
};

export const getInfoByUsername = (username: string) => {
  return alovaInstance.Post<UserInfo>('/user/user', { username });
};

export const modifyUserInfo = (field: string, value: string) => {
  return alovaInstance.Post<Result>('/user/modify', { field, value });
};

export const modifyUserAvatar = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return alovaInstance.Post<UploadResult>('/user/avatar', form);
};
