import { alovaInstance } from './instance';

import type { Result, Topic, User } from '@/types';

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
