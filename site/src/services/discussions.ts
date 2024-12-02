import type { Discussion, Result } from '@/types';
import { alovaInstance } from './instance';

export const getDiscussions = (
  last: number,
  limit: number,
  topic_id: number,
) => {
  return alovaInstance.Post<Result<Discussion[]>>(
    `/discussion/${topic_id}/list`,
    {
      last,
      limit,
    },
  );
};
