import type { Discussions } from '@/types';
import { alovaInstance } from './instance';

export const getDiscussions = (
  last: number,
  limit: number,
  topic_id: number,
) => {
  return alovaInstance.Post<Discussions>(`/discussion/list/${topic_id}`, {
    last,
    limit,
  });
};
