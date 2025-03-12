import { genForm } from '@/utils';
import { alovaInstance } from './instance';

import type { UploadForm, User, UserVisitLog, Result } from '@/types';

export const getVisitLogs = (page: number, limit: number) => {
  return alovaInstance.Get<Result<UserVisitLog[]>, UserVisitLog>('/me/logs', {
    params: {
      page,
      limit,
    },
  });
};

export const getSessionUserInfo = () => {
  return alovaInstance.Get<User>('/me/info', { cacheFor: null });
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

export const modifyPassword = (oldPassword: string, newPassword: string) => {
  return alovaInstance.Post<string[]>('/me/password', {
    oldPassword,
    newPassword,
  });
};
