import { alovaInstance } from './instance';

import type { Result, Topic, User } from '@/types';

export const getUserDetailByUsername = (username: string) => {
  return alovaInstance.Get<User>(`/user/${username}/info`);
};

export const getTopicsByUsername = (
  page: number,
  limit: number,
  username: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/user/${username}/topics`, {
    params: {
      page,
      limit,
    },
  });
};

export const getLikedTopicsByUsername = (
  page: number,
  limit: number,
  username: string,
) => {
  return alovaInstance.Get<Result<Topic[]>>(`/user/${username}/liked`, {
    params: {
      page,
      limit,
    },
  });
};
