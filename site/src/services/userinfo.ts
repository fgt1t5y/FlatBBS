import { requester } from './instance';
import type { RequestResult } from '@/types';

export const getUserInfo = () => {
  return requester.post<RequestResult>('user/info');
};

export const modifyUserInfo = (field: string, value: string) => {

}
