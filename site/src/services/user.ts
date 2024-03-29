import { alovaInstance } from './instance';
import type { Result, UserInfo } from '@/types';

export const getUserInfo = () => {
  return alovaInstance.Post<UserInfo>('/user/info');
};

export const modifyUserInfo = (field: string, value: string) => {
  return alovaInstance.Post<Result>('/user/modify', { field, value });
};
