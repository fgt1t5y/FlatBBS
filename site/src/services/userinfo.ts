import { genForm } from '@/utils';
import { requester } from './instance';
import type { RequestResult, UserModifyForm } from '@/types';

export const getUserInfo = () => {
  return requester.post<RequestResult>('user/info');
};

export const modifyUserInfo = (field: string, value: string) => {
  const form = genForm<UserModifyForm>({
    field: field,
    value: value,
  });

  return requester.post<RequestResult>('user/modify', form);
};
