import { genForm } from '@/utils';
import { alovaInstance } from './instance';

import type { Result, Topic, UploadForm, User } from '@/types';

export const getSessionUserInfo = () => {
  return alovaInstance.Get<User>('/user/me');
};

export const getUserDetailByUsername = (username: string) => {
  return alovaInstance.Get<User>(`/user/${username}/info`);
};

export const getTopicsByUsername = (
  last: number,
  limit: number,
  username: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/user/${username}/topics`, {
    params: {
      last,
      limit,
    },
  });
};

export const getLikedTopicsByUsername = (
  last: number,
  limit: number,
  username: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/user/${username}/liked`, {
    params: {
      last,
      limit,
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
