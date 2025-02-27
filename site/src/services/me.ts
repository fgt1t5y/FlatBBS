import { genForm } from '@/utils';
import { alovaInstance } from './instance';

import type { UploadForm, User, IVisitLog, Result } from '@/types';

export const getVisitLogs = (page: number, limit: number) => {
  return alovaInstance.Get<Result<IVisitLog[]>, IVisitLog>('/me/logs', {
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

export const modifyPassword = (old_password: string, new_password: string) => {
  return alovaInstance.Post<string[]>('/me/password', {
    old_password,
    new_password,
  });
};
